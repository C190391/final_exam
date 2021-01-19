<?php

class Product {

	/**
	 * プロパティ
	 */
	private $id;
	private $name;
	private $price;
	private $category;
	private $image;
	private $detail;

	/**
	 * コンストラクタ
	 * @param int ID
	 * @param string name
	 * @param int price
	 * @param string category 
	 * @param string image
	 * @param string detail
	 */
	function __construct(int $id, string $name, int $price, string $category, string $image, string $detail) {
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->category = $category;
		$this->image = $image;
		$this->detail = $detail;
	}

	/** アクセサメソッド群 */
    function setId(int $id):void {
		$this->id = $id;
	}

	function getId():int {
		return $this->id;
	}

    
	function setName(string $name):void {
		$this->name = $name;
	}

	function getName():string {
		return $this->string;
	}

	function setPrice(int $price):void {
		$this->price = $price;
	}

	function getPrice():int {
		return $this->price;
	}

	function setCategory(string $category):void {
		$this->category = $category;
	}

	function getCategory():string {
		return $this->category;
	}

	function setImage(string $image):void {
		$this->image = $image;
	}

	function getImage():string {
		return $this->image;
	}

	function setDetail(string $detail):void {
		$this->detail = $detail;
	}

	function getDetail():string {
		return $this->detail;
	}

}