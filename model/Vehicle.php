<?php

	class Vehicle
	{

		private $id;
		private $licensePlate;
		private $year;
		private $dailyRate;
		private $status;
		private $model;

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
		public function getLicensePlate()
		{
			return strtoupper($this->licensePlate);
		}

		/**
		 * @param mixed $licensePlate
		 */
		public function setLicensePlate($licensePlate)
		{
			$this->licensePlate = $licensePlate;
		}

		/**
		 * @return mixed
		 */
		public function getYear()
		{
			return $this->year;
		}

		/**
		 * @param mixed $year
		 */
		public function setYear($year)
		{
			$this->year = $year;
		}

		/**
		 * @return mixed
		 */
		public function getDailyRate()
		{
			return $this->dailyRate;
		}

		/**
		 * @param mixed $dailyRate
		 */
		public function setDailyRate($dailyRate)
		{
			$this->dailyRate = $dailyRate;
		}

		/**
		 * @return mixed
		 */
		public function getStatus()
		{
			return $this->status;
		}

		/**
		 * @param mixed $status
		 */
		public function setStatus($status)
		{
			$this->status = $status;
		}

		/**
		 * @return mixed
		 */
		public function getModel()
		{
			return $this->model;
		}

		/**
		 * @param mixed $model
		 */
		public function setModel($model)
		{
			$this->model = $model;
		}

	}