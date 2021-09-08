<?php

	class Model
	{

		private $id;
		private $description;
		private $brand;

		/**
		 * @return mixed
		 */
		public function getId()
		{
			return $this->id;
		}

		/**
		 * @param mixed $id
		 */
		public function setId($id)
		{
			$this->id = $id;
		}

		/**
		 * @return mixed
		 */
		public function getDescription()
		{
			return $this->description;
		}

		/**
		 * @param mixed $description
		 */
		public function setDescription($description)
		{
			$this->description = $description;
		}

		/**
		 * @return Brand
		 */
		public function getBrand()
		{
			return $this->brand;
		}

		/**
		 * @param Brand $brand
		 */
		public function setBrand($brand)
		{
			$this->brand = $brand;
		}

	}