<?php


	class Rent
	{
		private $id;
		private $initialDate;
		private $finalDate;
		private $status;
		private $vehicle;
		private $client;

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
		public function getInitialDate()
		{
			return $this->initialDate;
		}

		/**
		 * @param mixed $initialDate
		 */
		public function setInitialDate($initialDate)
		{
			$this->initialDate = $initialDate;
		}

		/**
		 * @return mixed
		 */
		public function getFinalDate()
		{
			return $this->finalDate;
		}

		/**
		 * @param mixed $finalDate
		 */
		public function setFinalDate($finalDate)
		{
			$this->finalDate = $finalDate;
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
		public function getVehicle()
		{
			return $this->vehicle;
		}

		/**
		 * @param mixed $vehicle
		 */
		public function setVehicle($vehicle)
		{
			$this->vehicle = $vehicle;
		}

		/**
		 * @return mixed
		 */
		public function getClient()
		{
			return $this->client;
		}

		/**
		 * @param mixed $client
		 */
		public function setClient($client)
		{
			$this->client = $client;
		}

	}