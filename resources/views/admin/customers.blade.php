@extends('layouts.admin')
@section('content')

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Customers</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-warning" onclick="exportTableToExcel()">Export Customers to
                                Excel</button>
                                
                                <button class="btn btn-warning" onclick="clearCustomer()">Clear Customers</button><br><br>
                            <!-- <h3 class="card-title">View Employee</h3> -->
                            <div class="table-responsive">
                                <table id="example5" class="display">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->id }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->address }},{{ $customer->address_two }},{{ $customer->address_three}},{{ $customer->city}},{{ $customer->postcode}},{{ $customer->state}}</td>
                                                <td>
                                                    <button type="button" title="View" data-toggle="modal"
                                                        onclick="openModalView( '{{ $customer->id }}','{{ $customer->name }}','{{ $customer->phone }}','{{ $customer->address }},{{ $customer->address_two }},{{ $customer->address_three}},{{ $customer->city}},{{ $customer->postcode}},{{ $customer->state}}')"
                                                        data-target="#modalView" class="btn btn-success"><i
                                                        class="lni lni-eye"></i></button> &nbsp;
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modalView">
        <div class="modal-dialog modal-md 
        modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewName"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-view">

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


@endsection

@section('script')
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"> </script>
    <script>
        
        function exportTableToExcel() {
        $(document).ready(function () {
            $("#example5").table2excel({
                    exclude: ".noExport",
                    filename: "Customers List"
                });
            });
        }

        function clearCustomer() {
            $.ajax({
                url: '{{ url('clearCustomer') }}',
                method: "get",
                data: {
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }

        function openModalView(id, name, phone, address) {


            document.getElementById("viewName").innerHTML = name;
            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<b>Name  </b>" + "<br/>" + name + "<br/>" +
                "<b>Phone Number  </b>" + "<br/>" + phone + "<br/>" +
                "</div><div class='col-sm-6'><b>Address  </b>" + "<br/>" + address + "<br/>" +
                "</div>" +
                "</div>";
        }

    </script>
@endsection
