<?php

declare( strict_types=1 );

/**
 * Created by stik_api.
 * User: Jose Manuel Suárez Bravo
 * Date: 31/01/20
 * Time: 13:03
 */

namespace App\Infrastructure\Persistence\Doctrine;


use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\ORM\QueryBuilder;

class  DoctrineSentences {

	private  $query;

	private $criteria;

	public function __construct(QueryBuilder$query, array
	$criteria) {
		$this->query = $query;
		$this->criteria = $criteria;
		$this->parseCriteria();

	}

	private function parseCriteria(): void
    {

		if(isset($this->criteria['must']) && is_array($this->criteria['must'])){

			foreach ($this->criteria['must'] as $key => $must){

					if(isset($must['type']) && $must['type'] === 'like'){

						$this->setLike($must);
						unset($this->criteria['must'][$key]);
					}

				if(isset($must['type']) && $must['type'] === 'eq'){

					$this->setEq($must);
					unset($this->criteria['must'][$key]);
				}
				if(isset($must['type']) && $must['type'] === 'where_in'){

					$this->setWhereIn($must);
					unset($this->criteria['must'][$key]);
				}
			}
			unset($this->criteria['must']);
		}


		if(isset($this->criteria['should']) && is_array($this->criteria['should'])){

			foreach ($this->criteria['should'] as $key => $should){



				if(isset($should['type']) && $should['type'] === 'eq'){

					$this->setEqOr($should);
					unset($this->criteria['should'][$key]);
				}

			}
			unset($this->criteria['should']);
		}

	}


	public function setEqOr($must): static
    {

		if(isset($must['field'], $must['value']) ){
			$globalSearch = new Orx();
			if(is_array($must['field'])){
				foreach ($must['field'] as $key =>$field){
					$this->query->setParameter('main_search_' . $this->getFieldToParameter($field),  $must['value'] );
				}
				foreach ($must['field'] as $key =>$field){
					$globalSearch->add($this->query->expr()->eq($field, ':main_search_' . $this->getFieldToParameter($field)));
				}

			}else{

				$this->query->setParameter('main_search_' . $this->getFieldToParameter($must['field']), $must['value'] );
				$globalSearch->add($this->query->expr()->eq($must['field'], ':main_search_' . $this->getFieldToParameter($must['field'])));
			}
			if ($globalSearch->count()) {
				$this->query->orWhere($globalSearch);
			}
		}
		return $this;
	}

	public function setEq($must): static
    {

		if(isset($must['field'], $must['value']) ){

			$globalSearch = new Orx();
			if(is_array($must['field'])){
				foreach ($must['field'] as $key =>$field){
					$this->query->setParameter('main_search_' . $this->getFieldToParameter($field),  $must['value'] );
				}
				foreach ($must['field'] as $key =>$field){
					$globalSearch->add($this->query->expr()->eq($field, ':main_search_' . $this->getFieldToParameter($field)));
				}

			}else{
               // dd($this->getFieldToParameter($must['field']));

				$this->query->setParameter('main_search_' . $this->getFieldToParameter($must['field']), $must['value'] );
				$globalSearch->add($this->query->expr()->eq($must['field'], ':main_search_' . $this->getFieldToParameter($must['field'])));
			}
			if ($globalSearch->count()) {
				$this->query->andWhere($globalSearch);
			}
		}
		return $this;
	}

	public function setLike($must): static
    {

		if(isset($must['field'], $must['value']) ){
			$globalSearch = new Orx();
			if(is_array($must['field'])){
				foreach ($must['field'] as $key =>$field){
					$this->query->setParameter('main_search_' . $this->getFieldToParameter($field), '%' . $must['value'] . '%');
				}
				foreach ($must['field'] as $key =>$field){
                    $fieldF = 'LOWER('.$field.')';
					$globalSearch->add($this->query->expr()->like($fieldF, 'LOWER( :main_search_' . $this->getFieldToParameter($field).')'));
				}
			}else{

                $fieldF = 'LOWER('.$must['field'].')';
				$this->query->setParameter('main_search_' . $this->getFieldToParameter($must['field']),'%' . $must['value'] . '%' );
				$globalSearch->add($this->query->expr()->like($fieldF, 'LOWER( :main_search_' . $this->getFieldToParameter($must['field']).' )'));
			}
			if ($globalSearch->count()) {
				$this->query->andWhere($globalSearch);
			}
		}
		return $this;
	}


	public function setWhereIn($must): static
    {

		if(isset($must['field'], $must['value']) ){
			$globalSearch = new Orx();
			if(is_array($must['field'])){
				foreach ($must['field'] as $key =>$field){
					$this->query->setParameter('main_search_' . $this->getFieldToParameter($field),  $must['value']);
				}
				foreach ($must['field'] as $key =>$field){

					$globalSearch->add($this->query->expr()->in($field, ':main_search_' . $this->getFieldToParameter($field)));
				}
			}else{

				$this->query->setParameter('main_search_' . $this->getFieldToParameter($must['field']), $must['value']  );
				$globalSearch->add($this->query->expr()->in($must['field'], ':main_search_' . $this->getFieldToParameter($must['field'])));
			}
			if ($globalSearch->count()) {
				$this->query->andWhere($globalSearch);
			}
		}
		return $this;
	}

	public function getQuery(): QueryBuilder
    {

		return $this->query;
	}

	private function getFieldToParameter($field): array|string
    {

		return  str_replace('.', '_', $field);

	}
}
