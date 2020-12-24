@extends('layouts.masteradmin')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Agents</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Agents</a></li>
                </ol>
            </div>
        </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h3 class="card-title">View Employee</h3> -->
                                {{-- <button type="button"
                                    class="btn btn-block bg-gradient-lightblue" data-toggle="modal" data-target="#modal-lg">
                                    <i class="fas fa-plus"></i> &nbsp Add Products
                                </button> --}}
                                <br />
                                <div class="table-responsive">
                                    <table id="example5" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount Withdraw</th>
                                            <th>Before Deducted</th>
                                            <th>After Deducted</th>
                                            <th>Bank</th>
                                            <th>Account No</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($commissionList as $com)
                                            <tr>
                                                <td>{{ $com->created_at }}</td>
                                                <td>RM {{ number_format($com->amountRequest, 2) }}</td>
                                                <td>{{ $com->before }}</td>
                                                <td>{{ $com->after }}</td>
                                                <td>{{ $com->bank }}</td>
                                                <td>{{ $com->accountNo }}</td>
                                                <td>{{ $com->status }}</td>
                                                <td><select onchange="location = this.value;" class="btn btn-default">
                                                        <option value="" hidden>Choose</option>
                                                        <option value="/master-commission-approve/{{ $com->id }}">Approve
                                                        </option>
                                                        <option value="/master-commission-decline/{{ $com->id }}">Decline
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        document.getElementById("manageProduct").className = "nav-link active";

        function openModalEdit(name, price, desc) {

            document.getElementById("productNameEdit").value = name;
            document.getElementById("productPriceEdit").value = price;
            document.getElementById("productDescEdit").value = desc;

        }

        function openModalView(name, price, desc) {

            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<b>Price: RM  </b>" + price + "<br/>" +
                "<b>Product Name:  </b>" + name + "<br/>" +
                "<b>Description: </b>" + desc + "<br/>" +
                "</div>";
            "</div>";
        }

    </script>
@endsection
