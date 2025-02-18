@extends('admin.layouts.master') 
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   @if (Session::has('success'))
    <div class="notification-green">
        <p>{{ Session::get('success') }}</p>
    </div>
   @endif 
   @if (Session::has('unsuccess'))
    <div class="notification-red">
        <p>{{ Session::get('unsuccess') }}</p>
    </div>
   @endif
   <h2>All Contacts List</h2>
</div>
<div class="main-table">
    <div class="data-table-listing">
        <div class="btn-pixxelu">
            <a href="{{ url('admin/export-contacts') }}" class="export"><img src="{{ url('public/admin/images/csv-file.svg') }}"></a>
        </div>
    </div>
    <div class="scrolling-data-table">
        <div class="card-body">
            <table id="example1" class="rwd-table cloud-path">
                <thead>
                <tr  class="sticky">
                    <th>Sr.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Companye</th>
                    <th>Message</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $count = 1; @endphp
                @foreach($all_contacts as $contact)   
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $contact->name }} </td>
                        <td>{{ $contact->email ??'-' }}</td>
                        <td><a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $contact->mobile) }}" target="_blank">{{ substr($contact->mobile, 0, 5) . '-' . substr($contact->mobile, 5) }}</a></td>
                        <td>{{ $contact->company ??'-' }}</td>
                        <td>{{ $contact->message ??'-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($contact->created_at)->format('d M Y') }}</td>
                        @if($contact->status == 'Active') 
                            <td class="green-color"><span>Active</span></td>
                        @elseif($contact->status == 'Pending') 
                            <td class="pink-color"><span>Pending</span></td>
                        @elseif($contact->status == 'Suspend')
                            <td class="red-color"><span>Suspend</span></td>
                        @elseif($contact->status == 'Approved')
                            <td class="purple-color"><span>Approved</span></td>
                        @else
                            <td></td>
                        @endif
                        <td>
                            <a class="btn btn-danger btn-sm delete_contact_record" data-contact_id="{{ $contact->id }}"><i class="fas fa-trash" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection