<?php
namespace Deven\UserManager\Ui\DataProvider\User;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Deven\UserManager\Model\ResourceModel\User\CollectionFactory;

class ListingDataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        return [
            'totalRecords' => $this->collection->getSize(), // total count
            'items' => $this->collection->getData()         // actual rows
        ];
    }
}
