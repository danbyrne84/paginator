<?php

namespace Danbyrne84;

interface Pagination
{
	/** @return iterable */
	public function elements(): iterable;
	/** @return int */
	public function currentPage(): int;
	/** @return int[] */
	public function pages(): array;
	/** @return int */
	public function totalElements(): int;
	/** @return int */
	public function totalElementsOnCurrentPage(): int;
	/** @return int */
	public function totalElementsPerPage(): int;
}