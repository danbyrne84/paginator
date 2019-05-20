<?php
namespace Danbyrne84;

require('Interfaces/Pagination.php');

class Paginator
{
	private $_itemsPerPage = 0;
	private $_totalItems = 0;
	
	private $_totalPages = 1;
	private $_currentPage = 1;
	private $_pages;

	public function __construct(iterable $dataSource, int $itemsPerPage = 5)
	{
		if($dataSource == null) throw new Exception("Iteratable must not be null");

		$this->_dataSource = $dataSource;
		$this->_itemsPerPage = $itemsPerPage;
	}

	public function paginate(int $requestedPage = 1): Pagination  {

		$this->_currentPage = $requestedPage;

		if(!isset($this->_pages)) {

			$curPage = 1;
			$curPageItem = 0;
			$totalItems = 0;

			foreach($this->_dataSource as $item){
				if(!isset($this->_pages[$curPage])){ $this->_pages[$curPage] = []; }

				array_push($this->_pages[$curPage], $item);

				$totalItems++;
				$curPageItem++;

				if($curPageItem >= $this->_itemsPerPage){
					$curPageItem = 0;
					$curPage++;
				}
			}
		}

		return new Page($this->_pages[$this->_currentPage], $this->_currentPage, count($this->_pages), $totalItems, count($this->_pages[$this->_currentPage]), $this->_itemsPerPage);
	}
}

class Page implements Pagination {

	private $_dataSource;

	private $_currentPage;
	private $_totalPages;
	private $_currentPageItems;
	private $_pageSize;

	public function __construct(iterable $dataSource, int $currentPage, int $totalPages, int $totalItems, int $currentPageItems, int $pageSize){
		$this->_dataSource = $dataSource;

		$this->_currentPage = $currentPage;
		$this->_totalPages = $totalPages;
		$this->_totalItems = $totalItems;
		$this->_currentPageItems = $currentPageItems;
		$this->_pageSize = $pageSize;
	}

	/** @return iterable */
	public function elements(): iterable {
		return $this->_dataSource;
	}

	/** @return int */
	public function currentPage(): int {
		return $this->_currentPage;
	}

	/** @return int[] */
	public function pages(): array {
		return range(1, $this->_totalPages);
	}

	/** @return int */
	public function totalElements(): int {
		return $this->_totalItems;
	}

	/** @return int */
	public function totalElementsOnCurrentPage(): int {
		return count($this->_dataSource);
	}

	/** @return int */
	public function totalElementsPerPage(): int {
		return $this->_pageSize;
	}

	public function totalPages(): int {
		return $this->_totalPages;
	}
}