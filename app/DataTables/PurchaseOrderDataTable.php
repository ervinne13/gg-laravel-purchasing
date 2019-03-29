<?php

namespace App\DataTables;

use App\User;
use App\Models\PurchaseOrder;
use Yajra\DataTables\Services\DataTable;

class PurchaseOrderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', function(PurchaseOrder $po) {
                return view('datatables.actions.purchase-order', ['po' => $po]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PurchaseOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PurchaseOrder $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '100px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return ['id', 'buyer', 'supplier', 'total_cost', 'purpose'];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PurchaseOrder_' . date('YmdHis');
    }
}
