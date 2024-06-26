<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Builder;


class OrderDataTable extends BaseDataTable
{

    protected $nameTable = 'orderTable';

    public function __construct(
        OrderRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.orders.datatable.action',
            'code' => 'admin.orders.datatable.code',
            'status' => 'admin.orders.datatable.status',
            'payment' => 'admin.orders.datatable.payment',
            'shipping' => 'admin.orders.datatable.shipping',
            'customer' => 'admin.orders.datatable.customer',
            'driver' => 'admin.orders.datatable.driver',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8,9];

        $this->columnSearchDate = [7];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => PaymentMethod::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => ShippingMethod::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => OrderStatus::asSelectArray()
            ],

        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.order', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'code' => $this->view['code'],
            'created_at' => '{{ format_date($created_at) }}',
            'total' => '{{ format_price($total) }}',
            'transport_fee' => '{{ format_price($transport_fee) }}',
            'status' => $this->view['status'],
            'payment_method' => $this->view['payment'],
            'shipping_method' => $this->view['shipping'],
            'customer_id' => function ($order) {
                return view($this->view['customer'],
                    [
                        'customer_name' => $order->customer->fullname,
                        'customer_id' => $order->customer_id,
                    ]
                )->render();
            },
            'driver_id' => function ($order) {
                $driverName = $order->driver && $order->driver->user ? $order->driver->user->fullname : 'N/A';
                return view($this->view['driver'], [
                    'driver_name' => $driverName,
                    'driver_id' => $order->driver_id,
                ])->render();
            },


        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['code', 'action', 'status', 'payment_method',
            'customer_id', 'driver_id', 'shipping_method'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [

        ];
    }
}
