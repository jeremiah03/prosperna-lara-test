@extends('layouts.master')

@section('content')
    <section>
        <div class="container px-4 px-lg-5 mb-5">
            <div class="row">
                <div class="col-6">
                    <h3>Manage Product</h3>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i>
                        Add Product
                    </a>
                </div>
                <div class="col-12">
                    <table class="table" id="products-table">
                        <thead class="table-dark">
                            <th>Category</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('link-script')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js">
    </script>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const table = $('#products-table').DataTable({
                ajax: {
                    url: '/product/data',
                    dataSrc: ''
                },
                columns: [{
                        data: 'category.name'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'formatted_price'
                    },
                    {
                        data: null,
                        render: (data) =>
                            `<a class="mx-1 " href="/product/${data.id}/edit">Edit</a><a class="mx-1" href="#">Delete</a>`
                    },
                ]
            });
        });
    </script>
@endsection
