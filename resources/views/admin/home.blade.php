@extends('admin.layouts.master')
@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="row">
    @php
      $sales = DB::table('order')
                ->select('order_details.price','order_details.quantity')
                ->join('order_details', 'order_details.order_id', '=' ,'order.id')
                ->whereMonth('order_date','=',Carbon::now('Asia/Ho_Chi_Minh')->month)
                ->where('status','=','2')
                ->get();      
        $total = 0;
        foreach ($sales as $sale) {
            $sum = $sale->price * $sale->quantity;
            $total += $sum;
        }
                   
    @endphp
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Doanh thu tháng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{currency_format($total)}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    {{-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Earnings (Annual)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Earnings (Monthly) Card Example -->
    @php
        $count_order_success = DB::table('order')
                                ->select(DB::raw('count(id) as total_order'))
                                ->whereMonth('order_date','=',Carbon::now('Asia/Ho_Chi_Minh')->month)
                                ->where('status','=','2')
                                ->first();
                   
    @endphp  
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn thành công
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$count_order_success->total_order}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->   
    @php
        $count_order_cancel = DB::table('order')
                                ->select(DB::raw('count(id) as total_order'))
                                ->whereMonth('order_date','=',Carbon::now('Asia/Ho_Chi_Minh')->month)
                                ->where('status','=','-1')
                                ->first();
               
    @endphp  
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Đơn hủy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_order_cancel->total_order}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-3">
        <input type="date" id="start-date" class="form-control">
    </div>
    <div class="col-md-3">
        <input type="date" id="end-date" class="form-control">
    </div>
    <div class="col-md-2">
        <button id="filter-range" class="btn btn-primary">Lọc</button>
    </div>
</div>

<div class="row">
    <!-- Biểu đồ doanh thu theo tháng -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="mb-3">📈 Doanh thu theo tháng</h4>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Biểu đồ doanh thu theo danh mục -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="mb-3">📊 Doanh thu theo danh mục</h4>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- Biểu đồ top sản phẩm bán chạy -->
    <div class="col-md-6 offset-md-3 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="mb-3">🥇 Top sản phẩm bán chạy</h4>
            <canvas id="topProductChart"></canvas>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    var channel = pusher.subscribe('order-channel');
    channel.bind('ordersucess-event', function(data) {
        $('#order-wait').html(data.orderCount);
        toastr.success("Bạn có một đơn hàng mới, mã đơn hàng: #" + data.order.id, 'Thông báo', {timeOut: 50000})
    });
  let salesChart, categoryChart, topProductChart;

    // Biểu đồ doanh thu theo ngày
    function loadSalesRange(start = null, end = null) {
    let url = "{{ route('admin.sales-range') }}";
    if (start && end) url += `?start=${start}&end=${end}`;

    $.get(url, function (data) {
        let datasets = [];

        // Nếu có daily
        if (data.daily.length > 0) {
            datasets.push({
                label: "Doanh thu theo ngày",
                data: data.daily.map(item => item.total),
                borderColor: "blue",
                backgroundColor: "rgba(0,0,255,0.2)",
                yAxisID: 'y',
                tension: 0.3
            });
        }

        // Nếu có monthly
        if (data.monthly.length > 0) {
            datasets.push({
                label: "Doanh thu theo tháng",
                data: data.monthly.map(item => item.total),
                borderColor: "green",
                backgroundColor: "rgba(0,128,0,0.2)",
                yAxisID: 'y',
                tension: 0.3
            });
        }

        // Nếu có yearly
        if (data.yearly.length > 0) {
            datasets.push({
                label: "Doanh thu theo năm",
                data: data.yearly.map(item => item.total),
                borderColor: "red",
                backgroundColor: "rgba(255,0,0,0.2)",
                yAxisID: 'y',
                tension: 0.3
            });
        }

        // Xác định nhãn: nếu quá dài thì ưu tiên tháng/năm
        let labels = [];
        if (data.daily.length <= 31) {
            labels = data.daily.map(item => item.label);
        } else if (data.monthly.length <= 24) {
            labels = data.monthly.map(item => item.label);
        } else {
            labels = data.yearly.map(item => item.label);
        }

        if (salesChart) salesChart.destroy();

        salesChart = new Chart(document.getElementById("salesChart"), {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                stacked: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
}

    // Biểu đồ doanh thu theo danh mục
    function loadSalesByCategory(start = null, end = null) {
        let url = "{{ route('admin.sales-by-category') }}";
        if (start && end) url += `?start=${start}&end=${end}`;

        $.get(url, function (data) {
            let labels = data.map(item => item.name);
            let values = data.map(item => item.total_sales);

            if (categoryChart) categoryChart.destroy();

            categoryChart = new Chart(document.getElementById("categoryChart"), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Doanh thu theo danh mục",
                        data: values,
                        backgroundColor: "rgba(54, 162, 235, 0.6)",
                        borderColor: "blue",
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        });
    }

    // Biểu đồ top sản phẩm bán chạy
    function loadTopProducts(start = null, end = null) {
        let url = "{{ route('admin.top-products') }}";
        if (start && end) url += `?start=${start}&end=${end}`;

        $.get(url, function (data) {
            let labels = data.map(item => item.name);
            let values = data.map(item => item.total_qty);

            if (topProductChart) topProductChart.destroy();

            topProductChart = new Chart(document.getElementById("topProductChart"), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Sản phẩm bán chạy",
                        data: values,
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.6)",
                            "rgba(54, 162, 235, 0.6)",
                            "rgba(255, 206, 86, 0.6)",
                            "rgba(75, 192, 192, 0.6)",
                            "rgba(153, 102, 255, 0.6)"
                        ]
                    }]
                }
            });
        });
    }

    // Bộ lọc ngày
    $("#filter-range").click(function () {
        let start = $("#start-date").val();
        let end = $("#end-date").val();

        if (!start || !end) {
            alert("Vui lòng chọn ngày bắt đầu và kết thúc!");
            return;
        }

        loadSalesRange(start, end);
        loadSalesByCategory(start, end);
        loadTopProducts(start, end);
    });

    // Load mặc định
    loadSalesRange();
    loadSalesByCategory();
    loadTopProducts();
</script>
@endsection