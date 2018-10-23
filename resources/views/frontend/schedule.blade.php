@extends('frontend.layout')
@section('title','YNetPla')
@section('css')
@stop
@section('content')
<ul class="nav nav-tabs" style="display: none;">
    <li class="active"><a href="#tab1" data-toggle="tab">Shipping</a></li>
    <li><a href="#tab2" data-toggle="tab">Quantities</a></li>
    <li><a href="#tab3" data-toggle="tab">Summary</a></li>
</ul>

<!-- <div class="tab-content">
    <div class="tab-pane active" id="tab1">

        <a class="btn btn-primary btnNext" >Next</a>
    </div>
    <div class="tab-pane" id="tab2">
        <a class="btn btn-primary btnNext" >Next</a>
        <a class="btn btn-primary btnPrevious" >Previous</a>
    </div>
    <div class="tab-pane" id="tab3">
        <a class="btn btn-primary btnPrevious" >Previous</a>
    </div>
</div> -->
        <section class="sec-schedule">
            <div class="container">
                <a href="javascript:history.go(-1)">
                {{-- <a href="javascript:history.back()"> --}}
                    <button style="margin-bottom: 10px; width: 112px; height: 38px; border-radius: 4px; background-color: #00557e; box-shadow: 1.5px 2.598px 3px 0px #171717; color: #ffffff; border: 0; font-family: 'Gotham-Book'; line-height: 12px; font-size: 14px; letter-spacing: 1px;">
                        <li class="fa fa-arrow-left"></li> Go Back
                    </button>
                </a>
                <div class="row">
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane active " id="tab1">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="scope btn-table"><button class="table-btn btnPrevious"><img src="{{asset('frontend')}}/img/table-btn-left.png" class="img-responsive" style="margin: 0 auto;"></button><button class="table-btn btnNext"><img src="{{asset('frontend')}}/img/table-btn-right.png" class="img-responsive" style="margin: 0 auto;"></button></th>
                                            <th scope="col">20:00</th>
                                            <th scope="col">20:30</th>
                                            <th scope="col">21:00</th>
                                            <th scope="col">21:30</th>
                                            <th scope="col">22:00</th>
                                            <th scope="col">22:30</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">CW</th>
                                            <td colspan="2"><a href="" title="Penn & Teller">Penn & Teller: Fool Us: 5x07</a></td>
                                            <td><a href="" title="Whose Line Is">Whose Line Is...</a></td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">FOX</th>
                                            <td colspan="4"><a href="" title="So You Think You Can Dance">So You Think You Can Dance: 15x09</a></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CBS</th>
                                            <td colspan="2"></td>
                                            <td colspan="2"><a href="" title="Salvation">Salvation: 2x07</a></td>
                                            <td colspan="2"><a href="" title="Elementary">Elementary: 6x14</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">NBS</th>
                                            <td colspan="4"><a href="" title="American Ninja Warrior">American Ninja Warrior: 10x10</a></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ABC</th>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">AMC</th>
                                            <td colspan="2"></td>
                                            <td colspan="2"><a href="" title="Better Call Saul">Better Call Saul: 4x01</a></td>
                                            <td colspan="2"><a href="" title="Lodge 49">Lodge 49: 1x01</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">MTV</th>
                                            <td colspan="2"></td>
                                            <td colspan="2"><a href="" title="Teen Mom 2">Teen Mom 2: 8x32</a></td>
                                            <td colspan="2"><a href="Floribama Shore">Floribama Shore: 2x05</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">DIY</th>
                                            <td colspan="2"></td>
                                            <td><a href="" title="Street Out">Street Out...</a></td>
                                            <td><a href="" title="Street Out">Street Out...</a></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Disney</th>
                                            <td colspan="6"><a href="" title="Andi Mack">Andi Mack: 2x23</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">PBS</th>
                                            <td colspan="4"></td>
                                            <td colspan="2"><a href="" title="POV">POV: 31x08</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Lifetime</th>
                                            <td colspan="2"></td>
                                            <td colspan="1"><a href="" title="Live PD Prese">Live PD Prese...</a></td>
                                            <td colspan="1"><a href="" title="Live PD Prese">Live PD Prese...</a></td>
                                            <td colspan="2"><a href="" title="Escaping Polygamy">Escaping Polygamy: 4x08</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Audience</th>
                                            <td colspan="2"><a href="" title="Off Camera with Sam">Off Camera with Sam...</a></td>
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Paramo...</th>
                                            <td colspan="4"></td>
                                            <td colspan="2"><a href="" title="Rest in Power">Rest in Power: The Trayvon...</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ID</th>
                                            <td colspan="4"></td>
                                            <td colspan="2"><a href="" title="The Real Story with Maria">The Real Story with Maria...</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Food</th>
                                            <td colspan="2"></td>
                                            <td colspan="2"><a href="" title="Kids Baking Championship">Kids Baking Championship: 5x01</a></td>
                                            <td><a href="" title="Reality Cup">Reality Cup...</a></td>
                                            <td><a href="" title="Reality Cup">Reality Cup...</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Bravo</th>
                                            <td colspan="2"></td>
                                            <td colspan="2"><a href="" title="The Real Housewives of">The Real Housewives of...</a></td>
                                            <td colspan="2"><a href="" title="Southern Charm Savannah">Southern Charm Savannah...</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Travel</th>
                                            <td colspan="2"></td>
                                            <td colspan="4"><a href="" title="Man vs Food">Man vs Food: 3x1</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Oxygen</th>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Telemu...</th>
                                            <td colspan="2"></td>
                                            <td colspan="4"><a href="" title="Sin Senos Sí Hay Paraíso">Sin Senos Sí Hay Paraíso: 3x40</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CNBC</th>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">TCL</th>
                                            <td colspan="2"></td>
                                            <td colspan="4"><a href="" title="Counting On">Counting On: 8x02</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">TV One</th>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CNN</th>
                                            <td colspan="2"><a href="" title="Anderson Cooper 360°">Anderson Cooper 360°: 16x155</a></td>
                                            <td colspan="4"><a href="" title="Cuomo Prime Time">Cuomo Prime Time: 1x40</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Bounce</th>
                                            <td colspan="2"></td>
                                            <td colspan="4"><a href="" title="In the Cut">In the Cut: 3x19</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Golf Ch...</th>
                                            <td colspan="2"></td>
                                            <td colspan="4"><a href="" title="Feherty">Feherty: 8x11</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Cooking</th>
                                            <td colspan="2"></td>
                                            <td colspan="4"><a href="" title="Southern and Hungry">Southern and Hungry</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">MSNBC</th>
                                            <td colspan="2"></td>
                                            <td colspan="4"><a href="" title="The Rachel Maddow Show">The Rachel Maddow Show: 2018-08-06</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                            <div class="tab-pane" id="tab2">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="scope btn-table"><button class="table-btn btnPrevious"><img src="{{asset('frontend')}}/img/table-btn-left.png" class="img-responsive" style="margin: 0 auto;"></button><button class="table-btn btnNext"><img src="{{asset('frontend')}}/img/table-btn-right.png" class="img-responsive" style="margin: 0 auto;"></button></th>
                                            <th scope="col">23:00</th>
                                            <th scope="col">23:30</th>
                                            <th scope="col">00:00</th>
                                            <th scope="col">00:30</th>
                                            <th scope="col">01:00</th>
                                            <th scope="col">01:30</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">CW</th>
                                            <td colspan="2">Penn & Teller: Fool Us: 5x07</td>
                                            <td>Whose Line Is...</td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Telemu...</th>
                                            <td colspan="2"></td>
                                            <td colspan="4">Sin Senos Sí Hay Paraíso: 3x40</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CNBC</th>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">TCL</th>
                                            <td colspan="2"></td>
                                            <td colspan="4">Counting On: 8x02</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">TV One</th>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CW</th>
                                            <td colspan="2">Penn & Teller: Fool Us: 5x07</td>
                                            <td>Whose Line Is...</td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">FOX</th>
                                            <td colspan="4">So You Think You Can Dance: 15x09</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Travel</th>
                                            <td colspan="2"></td>
                                            <td colspan="4">Man v. Food: 3x1</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Oxygen</th>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CNN</th>
                                            <td colspan="2">Anderson Cooper 360°: 16x155</td>
                                            <td colspan="4">Cuomo Prime Time: 1x40</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Bounce</th>
                                            <td colspan="2"></td>
                                            <td colspan="4">In the Cut: 3x19</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Golf Ch...</th>
                                            <td colspan="2"></td>
                                            <td colspan="4">Feherty: 8x11</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Cooking</th>
                                            <td colspan="2"></td>
                                            <td colspan="4">Southern and Hungry</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">MSNBC</th>
                                            <td colspan="2"></td>
                                            <td colspan="4">The Rachel Maddow Show: 2018-08-06</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="scope btn-table"><button class="table-btn btnPrevious"><img src="{{asset('frontend')}}/img/table-btn-left.png" class="img-responsive" style="margin: 0 auto;"></button><button class="table-btn btnNext"><img src="{{asset('frontend')}}/img/table-btn-right.png" class="img-responsive" style="margin: 0 auto;"></button></th>
                                            <th scope="col">02:00</th>
                                            <th scope="col">02:30</th>
                                            <th scope="col">03:00</th>
                                            <th scope="col">03:30</th>
                                            <th scope="col">04:00</th>
                                            <th scope="col">04:30</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="sched-input">
                            <h2>Date</h2>
                            <input id="today" type="date">
                        </div>
                        <div class="sched-input">
                            <h2>Country</h2>
                            <select>
                                <option>United States</option>
                            </select>
                        </div>
                        <div class="sched-input2">
                            <h2>Filter</h2>
                            <select>
                                <option></option>
                            </select>
                        </div>
                        <div class="sched-input2">
                            <h2>Show Type</h2>
                            <select>
                                <option></option>
                            </select>
                        </div>
                        <div class="sched-input2">
                            <h2>Genre</h2>
                            <select>
                                <option></option>
                            </select>
                        </div>
                        <div class="sched-input2">
                            <h2>Language</h2>
                            <select>
                                <option></option>
                            </select>
                        </div>
                        <div class="sched-input2">
                            <h2>Sort by</h2>
                            <select>
                                <option>Most Popular</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
@section('js')
<script type="text/javascript">
    let today = new Date().toISOString().substr(0, 10);
        document.querySelector("#today").value = today;
        $('.btnNext').click(function(){
  		$('.nav-tabs > .active').next('li').find('a').trigger('click');
	});
  	$('.btnPrevious').click(function(){
  		$('.nav-tabs > .active').prev('li').find('a').trigger('click');
	});
</script>
@stop