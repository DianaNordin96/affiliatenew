@extends('layouts.shogun')
@section('headScript')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Downline Agents</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Downline</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-warning" onclick="exportTableToExcel()">Export Downline List to
                                Excel</button>
                            <br /><br />
                            <div class="table-responsive">
                                <table id="example5" class="display example5" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th hidden>Role</th>
                                        <th>Change Role</th>
                                        <th class="noExport">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($users as $key=>$user)
                                        <tr>
                                            <td>{{ $user[0]->id }}</td>
                                            <td>{{ $user[0]->name }}</td>
                                            <td>{{ $user[0]->email }}</td>
                                            <td>{{ $user[0]->phone }}</td>
                                            <td hidden>{{ $user[0]->role }}</td>
                                            <td> 
                                                <select onchange="location = this.value;" class="btn btn-default">
                                                    @if($user[0]->role == '')
                                                    <option value="" selected>Not Yet Assign</option>
                                                    @endif
                                                    <option value="/manageDownlineShogun/damio/{{ $user[0]->id }}" @if($user[0]->role == 'damio') selected @endif>Damio</option>
                                                    <option value="/manageDownlineShogun/merchant/{{ $user[0]->id }}"  @if($user[0]->role == 'merchant') selected @endif>Merchant</option>
                                                    <option value="/manageDownlineShogun/dropship/{{ $user[0]->id }}"  @if($user[0]->role == 'dropship') selected @endif>Dropship</option>
                                                </select>
                                           </td>
                                            <td>
                                                <button type="button" title="View" data-toggle="modal"
                                                    onclick="openModalView('{{ $user[0]->id }}','{{ $user[0]->name }}','{{ $user[0]->email }}','{{ $user[0]->phone }}','{{ $user[0]->address }}','{{ $user[0]->icnumber }}','{{ $user[0]->dob }}','{{ $user[0]->image }}')"
                                                    data-target="#modalView" class="btn btn-success"><i class="lni lni-eye"></i></button> &nbsp;
                                                
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Pending Downline</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example5" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingUser as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                <button type="button" title="View" data-toggle="modal"
                                                    onclick="openModalView('{{ $user->id }}','{{ $user->name }}','{{ $user->email }}','{{ $user->phone }}','{{ $user->address }}','{{ $user->icnumber }}','{{ $user->dob }}','{{ $user->image }}')"
                                                    data-target="#modalView" class="btn btn-success"><i class="lni lni-eye"></i>
                                                </button> &nbsp;
                                                <button type="button"
                                                    onclick="location.href='/approveDownline-shogun/{{ $user->id }}'"
                                                    class="btn btn-warning">Approve</button>
                                                <button type="button"
                                                    onclick="location.href='/declineDownline-shogun/{{ $user->id }}'"
                                                    class="btn btn-danger">Decline</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

    </div>
</div>

        <div class="modal fade" id="modalView">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="viewName"> </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body-view">

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


@endsection

@section('script')
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"> </script>
<script>
    function exportTableToExcel() {
        $(document).ready(function () {
            $(".example5").table2excel({
                exclude: ".noExport",
                filename: "Agent List"
            });
        });

    }

    function openModalView(id, name, email, phone, address, ic, dob, image) {

    document.getElementById('viewName').innerText = name;

    if(image != ''){
    document.getElementById("modal-body-view").innerHTML =
        "<div class='row'>" +
        "<br/>" +
        "<div class='col-sm-6'>" +
        "<img style='display: block; margin-left: auto; margin-right: auto;' width='150px' height='150px' src='../imageUploaded/profile/" +
        image + "'/>" +
        "</div>" +
        "<div class='col-sm-6'>" +
        "<b>Name  </b>" + "<br/>" + name + "<br/>" +
        "<b>Email  </b>" + "<br/>" + email + "<br/>" +
        "<b>Phone Number  </b>" + "<br/>" + phone + "<br/>" +
        "<b>IC Number </b>" + "<br/>" + ic + "<br/>" +
        "<b>Address  </b>" + "<br/>" + address + "<br/>" +
        "</div>" +
        "</div>";

    }else{
        document.getElementById("modal-body-view").innerHTML =
        "<div class='row'>" +
        "<br/>" +
        "<div class='col-sm-6'>" +
        "<span>No Photo</span>" +
        "</div>" +
        "<div class='col-sm-6'>" +
        "<b>Name  </b>" + "<br/>" + name + "<br/>" +
        "<b>Email  </b>" + "<br/>" + email + "<br/>" +
        "<b>Phone Number  </b>" + "<br/>" + phone + "<br/>" +
        "<b>IC Number </b>" + "<br/>" + ic + "<br/>" +
        "<b>Address  </b>" + "<br/>" + address + "<br/>" +
        "</div>" +
        "</div>";
    }
}
</script>
@endsection
