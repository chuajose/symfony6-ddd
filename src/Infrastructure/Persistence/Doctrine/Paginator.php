<?php

declare( strict_types=1 );

/**
 * Created by stik_api.
 * User: Jose Manuel Suárez Bravo
 * Date: 22/02/19
 * Time: 13:50
 */

namespace App\Infrastructure\Persistence\Doctrine;


use Doctrine\ORM\Query\ResultSetMappingBuilder;

final class Paginator {

	private $count;
	private $currentPage;
	private $totalPages;

	public function paginate( $query, $page = 1, $limit = 10 ) {
		// setting current page
		$this->currentPage = $page;
		// set the limit

		$limit = (int) $limit;
		// this covers the NativeQuery case
		if ( is_a( $query, 'Doctrine\ORM\NativeQuery' ) ) {
			dd('NativeQuery');
			// do a count for all query, create a separate NativeQuery only for that
			$sqlInitial = $query->getSQL();

			$rsm = new ResultSetMappingBuilder( $query->getEntityManager() );
			$rsm->addScalarResult( 'count', 'count' );

			$sqlCount = 'select count(*) as count from (' . $sqlInitial . ') as item';
			$qCount   = $query->getEntityManager()->createNativeQuery( $sqlCount, $rsm );
			$qCount->setParameters( $query->getParameters() );

			$resultCount = (int) $qCount->getSingleScalarResult();
			$this->count = $resultCount;

			$query->setSQL( $query->getSQL() . ' limit ' . ( ( $page - 1 ) * $limit ) . ', ' . $limit );
		} // this covers the QueryBuilder case, turning it into Query
		elseif ( is_a( $query, 'DoctrineORMQueryBuilder' ) ) {
			dd('DoctrineORMQueryBuilder');
			// set limit and offset, getting the query out of queryBuilder
			$query = $query->setFirstResult( ( $page - 1 ) * $limit )->setMaxResults( $limit )->getQuery();

			// using already build Doctrine paginator to get a count
			// for all records. Saves load.
			$paginator   = new \Doctrine\ORM\Tools\Pagination\Paginator( $query, $fetchJoinCollection = true );
			$this->count = count( $paginator );
		}else{
			$paginator   = new \Doctrine\ORM\Tools\Pagination\Paginator( $query->getQuery(), $fetchJoinCollection = true );
			$paginator->setUseOutputWalkers(false);//TODO revisar porque si esto falla la consulta de getByTargetNameWithPermission. Parece ser que el problema es el select del stik, en lugar del stik_Realted
			$this->count =  $paginator->count();
			/*$sqlInitial = $query->getQuery()->getSQL();
			$rsm = new ResultSetMappingBuilder( $query->getEntityManager() );
			$rsm->addScalarResult( 'count', 'count' );
			$sqlCount = 'select count(*) as count from (' . $sqlInitial . ') as item';
			$qCount   = $query->getEntityManager()->createNativeQuery( $sqlCount, $rsm );
			$qCount->setParameters( $query->getParameters() );
			$resultCount = (int) $qCount->getSingleScalarResult();
			$this->count = $resultCount;


*/

			$query = $query->setFirstResult( ( $page - 1 ) * $limit )->setMaxResults( $limit )->getQuery();
         //   dd($query->getSql());
			//$query->useQueryCache(true)->useResultCache(true);

		}


		// set total pages
		$this->totalPages = ceil( $this->count / $limit );

		return $query->getResult();
	}

	/**
	 * get current page
	 *
	 * @return int
	 */
	public function getCurrentPage() {
		return $this->currentPage;
	}

	/**
	 * get total pages
	 *
	 * @return int
	 */
	public function getTotalPages() {
		return $this->totalPages;
	}

	/**
	 * get total result count
	 *
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}
}
