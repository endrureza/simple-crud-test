<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\MCluster;
use App\MCustomer;
use App\TdSalesDetail;
use App\ThSales;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display home page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $transactions = ThSales::with('customer')->get();

        return Inertia::render('Home', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Display create transaction page
     *
     * @param Request $request
     * @return void
     */
    public function createTransaction(Request $request)
    {
        return Inertia::render('TransactionCreate');
    }

    /**
     * Create new transaction
     *
     * @param Request $request
     * @return void
     */
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'transaction_number' => [
                'required',
            ],
            'transaction_date' => [
                'required',
            ],
            'customer' => [
                'required',
            ],
            'details' => [
                'required',
            ],
        ]);

        $transaction = new ThSales;
        $transaction->document_number = $request->transaction_number;
        $transaction->customer_id = $request->customer['id'];
        $transaction->date = $request->transaction_date;
        $transaction->notes = $request->notes ?: '';
        $transaction->total_sales_price = 0;
        $transaction->save();

        $total = 0;

        foreach ($request->details as $detail) {
            $transaction->details()->save(
                new TdSalesDetail([
                    'cluster_id' => $detail['cluster_id'],
                    'type_id' => $detail['type_id'],
                    'price' => $detail['price'],
                    'qty' => $detail['qty'],
                    'total' => $detail['total'],
                ])
            );

            $total = $total + $detail['total'];
        }

        $transaction->total_sales_price = $total;
        $transaction->save();

        return redirect('/');
    }

    /**
     * Display report transaction page
     *
     * @param Request $request
     * @return void
     */
    public function reportTransaction(Request $request)
    {
        $query = TdSalesDetail::query()->with([
            'transaction.customer',
            'cluster',
            'type',
        ]);

        if ($request->from) {
            $from = $request->from;

            $query = $query->whereHas('transaction', function ($q) use ($from) {
                $q->where('date', '>=', $from);
            });
        }

        if ($request->to) {
            $to = $request->to;

            $query = $query->whereHas('transaction', function ($q) use ($to) {
                $q->where('date', '<=', $to);
            });
        }

        if ($request->cluster) {
            $cluster = $request->cluster;

            $query = $query->whereHas('cluster', function ($q) use ($cluster) {
                $q->where('name', 'like', '%' . $cluster . '%');
            });
        }

        if ($request->type) {
            $type = $request->type;

            $query = $query->whereHas('type', function ($q) use ($type) {
                $q->where('name', 'like', '%' . $type . '%');
            });
        }

        $details = $query;

        if (!$request->from && !$request->to && !$request->cluster && !$request->type) {
            $details = $details->take(0)->get();
        } else {
            $details = $details->get();
        }

        return Inertia::render('TransactionReport', [
            'details' => $details,
        ]);
    }

    public function exportTransaction(Request $request)
    {
        return new TransactionExport($request->all());
    }

    /**
     * Display list customer page
     *
     * @param Request $request
     * @return void
     */
    public function listCustomer(Request $request)
    {
        $customers = MCustomer::get();

        return Inertia::render('CustomerList', [
            'customers' => $customers,
        ]);
    }

    /**
     * Display create customer page
     *
     * @param Request $request
     * @return void
     */
    public function createCustomer(Request $request)
    {
        return Inertia::render('CustomerCreate');
    }

    /**
     * Create new customer
     *
     * @param Request $request
     * @return void
     */
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
            ],
            'email' => [
                'required',
                'email:filter',
                'unique:m_customers,email',
            ],
            'phone' => [
                'required',
            ],
            'address' => [
                'required',
            ],
        ]);

        MCustomer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect('/customer');
    }

    /**
     * Display cluster data
     *
     * @param Request $request
     * @return void
     */
    public function clusters(Request $request)
    {
        $clusters = MCluster::with('types')->get();

        return response([
            'status' => 200,
            'data' => $clusters,
        ], 200);
    }

    /**
     * Display customer data
     *
     * @param Request $request
     * @return void
     */
    public function customers(Request $request)
    {
        $customers = MCustomer::get();

        return response([
            'status' => 200,
            'data' => $customers,
        ], 200);
    }
}
