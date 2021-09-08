<?php

	class Client
	{

		private $id;
		private $name;
		private $CNH;
		private $phone;
		private $email;

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
		public function getName()
		{
			return $this->name;
		}

		/**
		 * @param mixed $name
		 */
		public function setName($name)
		{
			$this->name = $name;
		}

		/**
		 * @return mixed
		 */
		public function getCnh()
		{
			return $this->CNH;
		}

		/**
		 * @param mixed $cnh
		 */
		public function setCnh($cnh)
		{
			$this->CNH = $cnh;
		}

		/**
		 * @return mixed
		 */
		public function getPhone()
		{
			return $this->phone;
		}

		/**
		 * @param mixed $phone
		 */
		public function setPhone($phone)
		{
			$this->phone = $phone;
		}

		/**
		 * @return mixed
		 */
		public function getEmail()
		{
			return $this->email;
		}

		/**
		 * @param mixed $email
		 */
		public function setEmail($email)
		{
			$this->email = $email;
		}

	}