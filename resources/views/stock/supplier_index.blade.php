@extends('layouts.app')

@section('title')
    供應商庫存
@stop

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>供應商庫存-{{\Carbon\Carbon::now()->subMonth()->monthName}}</h2>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">部門</span>
                </h4>
                <ul class="list-group mb-3">


                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice">
                                    全部
                                </a>
                            </h6>

                        </div>

                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice?dept=18">維他奶</a>
                            </h6>
                        </div>

                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice?dept=15">太古可樂</a>
                            </h6>
                        </div>

                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice?dept=38">匯泉</a>
                            </h6>
                        </div>

                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice?dept=27">現金購買</a>
                            </h6>
                        </div>

                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice?dept=17">時鮮果汁</a>
                            </h6>
                        </div>

                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice?dept=2">屈臣氏</a>
                            </h6>
                        </div>

                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="http://kbhdev.test/notice?dept=2">7式發展(糖業)有限公司</a>
                            </h6>
                        </div>

                    </li>

                </ul>

                <form class="card p-2" method="POST" action="http://kbhdev.test/notice">
                    <div class="input-group">
                        <input type="hidden" name="_token" value="kHqp50mJSGe9dlT239N2SygEHainrYWQk4VOc10W">                    <input id="search" name="search" type="text" class="form-control" placeholder="根據編號或主旨查詢" value="">
                        <input id="dept" name="dept" type="hidden" value="">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">查詢</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-8 mb-8">
                <table class="table">

                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" width="15%">編號</th>
                        <th scope="col" width="50%">貨名</th>
                        <th scope="col" width="20%">結存</th>
                        <th scope="col" width="15%">包裝</th>
                    </tr>
                    </thead>

                    <tbody class="table-striped" style="background-color: white">
                    <tr>
                    <td>1000001</td>
                    <td>咸麵粒</td>
                    <td><input class="input-sm" type="number" name="" id="" style="width:100%"></td>
                    <td><select name="" id="">
                            <option value="">個</option>
                            <option value="">箱</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>1000001</td>
                        <td>咸麵粒咸麵粒咸麵粒咸麵粒咸麵粒咸麵粒</td>
                        <td><input class="input-sm" type="number" name="" id="" style="width:100%"></td>
                        <td>個</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


