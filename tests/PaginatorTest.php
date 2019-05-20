<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PaginatorTest extends TestCase
{

	private $_basicTestItems = ['alpha', 'beta', 'delta', 'gamma'];

    /** @test */
    public function paginatorCanBeInitialisedDirectlyWithItems(): void
    {
        $this->assertInstanceOf(
            Danbyrne84\Paginator::class,
            new Danbyrne84\Paginator($this->_basicTestItems)
        );
    }

    /** @test */
    public function paginatorCanBeInitialisedWithArrayObject(): void
    {
        $this->assertInstanceOf(
            Danbyrne84\Paginator::class,
            new Danbyrne84\Paginator(new \ArrayObject($this->_basicTestItems))
        );
    }

    /** @test */
    public function paginatorPaginateShouldReturnInstanceOfPage(): void
    {
        $this->assertInstanceOf(
            Danbyrne84\Page::class,
            (new Danbyrne84\Paginator($this->_basicTestItems))->paginate()
        );
    }

    /** @test */
    public function paginatorCountShouldReturnCorrectItemCount(): void
    {
        $this->assertEquals(
            4,
            (new Danbyrne84\Paginator($this->_basicTestItems))->paginate()->totalElements()
        );
    }

    /** 
     * @test
     * @dataProvider collectionPageSizePageCountDataset
     */
    public function paginatorForGivenCollectionAndPageSizePageCountShouldMatch($collection, $pageSize, $pageCount): void
    {
        $this->assertEquals(
            $pageCount,
            (new Danbyrne84\Paginator($collection, $pageSize))->paginate()->totalPages()
        );
    }

    public function collectionPageSizePageCountDataset(){
    	return [
    		[$this->_basicTestItems, 1, 4],
    		[[1,2,3,4,5,6,7,8,9,10], 2, 5],
    		[new \ArrayObject([1,2,3,4,5,6,7,8,9,10]), 6, 2]
    	];
    }

    /** 
     * @test
     * @dataProvider collectionPageItemsPageDataset
     */
    public function paginatorForGivenCollectionAndPageSizeReturnedPagesShouldMatch($collection, $pageSize, $page, $pageItems): void
    {

		$paginator = (new Danbyrne84\Paginator($collection, $pageSize));

        $this->assertEquals(
            $pageItems,
            $paginator->paginate($page)->elements()
        );
    }

    public function collectionPageItemsPageDataset(){
    	return [
    		[$this->_basicTestItems, 2, 1, ['alpha','beta']],
    		[[1,2,3,4,5,6,7,8,9,10], 2, 2, [3,4]],
    		[new \ArrayObject([1,2,3,4,5,6,7,8,9,10]), 6, 2, [7,8,9,10]]
    	];
    }
}