@extends('partials.layout')

@section('title')
@parent
Welcome to CodeIgniter 4!
@endsection

@section('content')
@parent
<section>
    <table id="myTable">
    </table>
</section>
@endsection

@section('footer')
@parent
<footer>

    <div class="copyrights">

        <p>&copy; {{ date('Y') }} CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
            open source licence.</p>

    </div>

</footer>
@endsection

@section('script')
@parent
<link href="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet"
    type="text/css">
<script src="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.js"
    type="text/javascript"></script>

<script>
    let data = JSON.parse("{!! $users !!}");

    let obj = {
        headings: Object.keys(data[0]),
        data: []
    };

    for ( var i = 0; i < data.length; i++ ) {

        obj.data[i] = [];

        for (var p in data[i]) {
            if( data[i].hasOwnProperty(p) ) {
                obj.data[i].push(data[i][p]);
            }
        }
    }

    new DataTable("#myTable", {
        data: obj
    });
</script>
@endsection
