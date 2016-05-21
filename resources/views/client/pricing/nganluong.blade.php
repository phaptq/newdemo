@extends('client.master')

@section('content')
<!-- Intro -->
<section class="site-section site-section-light site-section-top themed-background-dark">
    <div class="container">
        <h1 class="text-center animation-slideDown"><i class="fa fa-thumbs-up"></i> <strong>Thanh toán qua Nganluong.vn</strong></h1>
        <h2 class="h3 text-center animation-slideUp">Chọn loại hình thanh toán phù hợp</h2>
    </div>
</section>
<!-- END Intro -->

<!-- Plans -->
<section class="site-content site-section">
    <div class="container">
        <div class="site-block">
            <div class="col-md-8 col-md-offset-3">
                <div class="clearfix has-error">
                    <span class="help-block">{{\Session::has('message')? \Session::get('message'): ''}}</span>
                </div>
                <h3>Chọn phương thức thanh toán</h3>
                <form id="nganluong_form"  name="NLpayBank" action="{{route('check_out_nganluong')}}" method="post">
                    {!!csrf_field()!!}
                    <table>
                        <tr><td colspan="2"><p><span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span> Bạn nhập đầy đủ thông tin sau. Thông tin phải chính xác, nếu có lỗi phát sinh do thông tin sai lệch, khiếu nại sẽ vô giá trị. </td>

                        </tr>
                        <tr class="{{ $errors->has('total_amount') ? ' has-error' : '' }}"><td>Số tiền thanh toán: </td>
                            <td>
                                <input type="hidden" style="width:270px" id="total_amount" name="total_amount" class="field-check form-control" value="{{$plan}}">
                                <input type="text" style="width:270px" id="total_amount" class="field-check form-control" value="{{$plan}}" disabled>
                                <span class="help-block has-error">{!! $errors->first('total_amount') !!}</span>
                            </td>
                        </tr>
                        <tr class="{{ $errors->has('buyer_fullname') ? ' has-error' : '' }}"><td>Họ Tên: </td>
                            <td>
                                 <input type="text" style="width:270px" id="fullname" name="buyer_fullname" class="field-check form-control" value="{{old('buyer_fullname')}}">
                                 <span class="help-block has-error">{!! $errors->first('buyer_fullname') !!}</span>
                            </td>
                        </tr>
                        <tr class="{{ $errors->has('buyer_email') ? ' has-error' : '' }}"><td>Email: </td>
                            <td>
                                 <input type="email" style="width:270px" id="fullname" name="buyer_email" class="field-check form-control" value="{{old('buyer_email')}}">
                                 <span class="help-block has-error">{!! $errors->first('buyer_email') !!}</span>
                            </td>
                        </tr>
                        <tr class="{{ $errors->has('buyer_mobile') ? ' has-error' : '' }}"><td>Số Điện thoại: </td>
                            <td>
                                 <input type="text" style="width:270px" id="fullname" name="buyer_mobile" class="field-check form-control" value="{{old('buyer_mobile')}}">
                                 <span class="help-block has-error">{!! $errors->first('buyer_mobile') !!}</span>
                            </td>
                        </tr>
                    </table>
                    <div class="clearfix {{ $errors->has('bankcode') ? ' has-error' : '' }}">
                        <span class="help-block has-error bankcode_field">{!! $errors->first('bankcode') !!}</span>
                    </div>
                    <ul class="list-content">
                        <li class="{{ $errors->has('bankcode') ? ' has-error' : '' }} form-group">
                            <label><input type="radio" value="NL" name="option_payment" selected="true">Thanh toán bằng Ví điện tử NgânLượng</label>
                            <div class="boxContent">
                                <p>
                                Thanh toán trực tuyến AN TOÀN và ĐƯỢC BẢO VỆ, sử dụng thẻ ngân hàng trong và ngoài nước hoặc nhiều hình thức tiện lợi khác.
                                Được bảo hộ & cấp phép bởi NGÂN HÀNG NHÀ NƯỚC, ví điện tử duy nhất được cộng đồng ƯA THÍCH NHẤT 2 năm liên tiếp, Bộ Thông tin Truyền thông trao giải thưởng Sao Khuê
                                <br/>Giao dịch. Đăng ký ví NgânLượng.vn miễn phí <a href="https://www.nganluong.vn/?portal=nganluong&amp;page=user_register" target="_blank">tại đây</a></p>
                            </div>
                        </li>
                        <li>
                            <label><input type="radio" value="ATM_ONLINE" name="option_payment">Thanh toán online bằng thẻ ngân hàng nội địa</label>
                            <div class="boxContent clearfix">
                                <p><i>
                                <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Bạn cần đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi thực hiện.</i></p>

                                        <ul class="cardList clearfix">
                                        <li class="bank-online-methods ">
                                            <label for="vcb_ck_on">
                                                <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                                <input type="radio" value="BIDV"  name="bankcode" >

                                        </label></li>
                                        <li class="bank-online-methods ">
                                            <label for="vcb_ck_on">
                                                <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                                <input type="radio" value="VCB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="vnbc_ck_on">
                                                <i class="DAB" title="Ngân hàng Đông Á"></i>
                                                <input type="radio" value="DAB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="tcb_ck_on">
                                                <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                                <input type="radio" value="TCB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_mb_ck_on">
                                                <i class="MB" title="Ngân hàng Quân Đội"></i>
                                                <input type="radio" value="MB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_vib_ck_on">
                                                <i class="VIB" title="Ngân hàng Quốc tế"></i>
                                                <input type="radio" value="VIB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_vtb_ck_on">
                                                <i class="ICB" title="Ngân hàng Công Thương Việt Nam"></i>
                                                <input type="radio" value="ICB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_exb_ck_on">
                                                <i class="EXB" title="Ngân hàng Xuất Nhập Khẩu"></i>
                                                <input type="radio" value="EXB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_acb_ck_on">
                                                <i class="ACB" title="Ngân hàng Á Châu"></i>
                                                <input type="radio" value="ACB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_hdb_ck_on">
                                                <i class="HDB" title="Ngân hàng Phát triển Nhà TPHCM"></i>
                                                <input type="radio" value="HDB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_msb_ck_on">
                                                <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                                <input type="radio" value="MSB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_nvb_ck_on">
                                                <i class="NVB" title="Ngân hàng Nam Việt"></i>
                                                <input type="radio" value="NVB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_vab_ck_on">
                                                <i class="VAB" title="Ngân hàng Việt Á"></i>
                                                <input type="radio" value="VAB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_vpb_ck_on">
                                                <i class="VPB" title="Ngân Hàng Việt Nam Thịnh Vượng"></i>
                                                <input type="radio" value="VPB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_scb_ck_on">
                                                <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                                                <input type="radio" value="SCB"  name="bankcode" >

                                        </label></li>



                                        <li class="bank-online-methods ">
                                            <label for="bnt_atm_pgb_ck_on">
                                                <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                                                <input type="radio" value="PGB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="bnt_atm_gpb_ck_on">
                                                <i class="GPB" title="Ngân hàng TMCP Dầu khí Toàn Cầu"></i>
                                                <input type="radio" value="GPB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="bnt_atm_agb_ck_on">
                                                <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                                <input type="radio" value="AGB"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="bnt_atm_sgb_ck_on">
                                                <i class="SGB" title="Ngân hàng Sài Gòn Công Thương"></i>
                                                <input type="radio" value="SGB"  name="bankcode" >

                                        </label></li>
                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_bab_ck_on">
                                                <i class="BAB" title="Ngân hàng Bắc Á"></i>
                                                <input type="radio" value="BAB"  name="bankcode" >

                                        </label></li>
                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_bab_ck_on">
                                                <i class="TPB" title="Tền phong bank"></i>
                                                <input type="radio" value="TPB"  name="bankcode" >

                                        </label></li>
                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_bab_ck_on">
                                                <i class="NAB" title="Ngân hàng Nam Á"></i>
                                                <input type="radio" value="NAB"  name="bankcode" >

                                        </label></li>
                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_bab_ck_on">
                                                <i class="SHB" title="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)"></i>
                                                <input type="radio" value="SHB"  name="bankcode" >

                                        </label></li>
                                        <li class="bank-online-methods ">
                                            <label for="sml_atm_bab_ck_on">
                                                <i class="OJB" title="Ngân hàng TMCP Đại Dương (OceanBank)"></i>
                                                <input type="radio" value="OJB"  name="bankcode" >

                                        </label></li>





                                    </ul>

                            </div>
                        </li>
                        <li>
                            <label><input type="radio" value="IB_ONLINE" name="option_payment">Thanh toán bằng Internet Banking</label>
                            <div class="boxContent">
                                <p><i>
                                        <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Bạn cần đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi thực hiện.</i></p>

                                <ul class="cardList clearfix">
                                    <li class="bank-online-methods ">
                                        <label for="vcb_ck_on">
                                            <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                            <input type="radio" value="BIDV"  name="bankcode" >

                                        </label></li>
                                    <li class="bank-online-methods ">
                                        <label for="vcb_ck_on">
                                            <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                            <input type="radio" value="VCB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="vnbc_ck_on">
                                            <i class="DAB" title="Ngân hàng Đông Á"></i>
                                            <input type="radio" value="DAB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="tcb_ck_on">
                                            <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                            <input type="radio" value="TCB"  name="bankcode" >

                                        </label></li>


                                </ul>

                            </div>
                        </li>
                        <li>
                            <label><input type="radio" value="ATM_OFFLINE" name="option_payment">Thanh toán atm offline</label>
                            <div class="boxContent">

                                <ul class="cardList clearfix">
                                    <li class="bank-online-methods ">
                                        <label for="vcb_ck_on">
                                            <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                            <input type="radio" value="BIDV"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="vcb_ck_on">
                                            <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                            <input type="radio" value="VCB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="vnbc_ck_on">
                                            <i class="DAB" title="Ngân hàng Đông Á"></i>
                                            <input type="radio" value="DAB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="tcb_ck_on">
                                            <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                            <input type="radio" value="TCB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_mb_ck_on">
                                            <i class="MB" title="Ngân hàng Quân Đội"></i>
                                            <input type="radio" value="MB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_vtb_ck_on">
                                            <i class="ICB" title="Ngân hàng Công Thương Việt Nam"></i>
                                            <input type="radio" value="ICB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_acb_ck_on">
                                            <i class="ACB" title="Ngân hàng Á Châu"></i>
                                            <input type="radio" value="ACB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_msb_ck_on">
                                            <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                            <input type="radio" value="MSB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_scb_ck_on">
                                            <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                                            <input type="radio" value="SCB"  name="bankcode" >

                                        </label></li>
                                    <li class="bank-online-methods ">
                                        <label for="bnt_atm_pgb_ck_on">
                                            <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                                            <input type="radio" value="PGB"  name="bankcode" >

                                        </label></li>

                                     <li class="bank-online-methods ">
                                        <label for="bnt_atm_agb_ck_on">
                                            <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                            <input type="radio" value="AGB"  name="bankcode" >

                                        </label></li>
                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_bab_ck_on">
                                            <i class="SHB" title="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)"></i>
                                            <input type="radio" value="SHB"  name="bankcode" >

                                        </label></li>




                                </ul>

                            </div>
                        </li>
                        <li>
                            <label><input type="radio" value="NH_OFFLINE" name="option_payment">Thanh toán tại văn phòng ngân hàng</label>
                            <div class="boxContent">

                                <ul class="cardList clearfix">
                                    <li class="bank-online-methods ">
                                        <label for="vcb_ck_on">
                                            <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                            <input type="radio" value="BIDV"  name="bankcode" >

                                        </label></li>
                                    <li class="bank-online-methods ">
                                        <label for="vcb_ck_on">
                                            <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                            <input type="radio" value="VCB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="vnbc_ck_on">
                                            <i class="DAB" title="Ngân hàng Đông Á"></i>
                                            <input type="radio" value="DAB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="tcb_ck_on">
                                            <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                            <input type="radio" value="TCB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_mb_ck_on">
                                            <i class="MB" title="Ngân hàng Quân Đội"></i>
                                            <input type="radio" value="MB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_vib_ck_on">
                                            <i class="VIB" title="Ngân hàng Quốc tế"></i>
                                            <input type="radio" value="VIB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_vtb_ck_on">
                                            <i class="ICB" title="Ngân hàng Công Thương Việt Nam"></i>
                                            <input type="radio" value="ICB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_acb_ck_on">
                                            <i class="ACB" title="Ngân hàng Á Châu"></i>
                                            <input type="radio" value="ACB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_msb_ck_on">
                                            <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                            <input type="radio" value="MSB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_scb_ck_on">
                                            <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                                            <input type="radio" value="SCB"  name="bankcode" >

                                        </label></li>



                                    <li class="bank-online-methods ">
                                        <label for="bnt_atm_pgb_ck_on">
                                            <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                                            <input type="radio" value="PGB"  name="bankcode" >

                                        </label></li>

                                    <li class="bank-online-methods ">
                                        <label for="bnt_atm_agb_ck_on">
                                            <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                            <input type="radio" value="AGB"  name="bankcode" >

                                        </label></li>
                                    <li class="bank-online-methods ">
                                        <label for="sml_atm_bab_ck_on">
                                            <i class="TPB" title="Tền phong bank"></i>
                                            <input type="radio" value="TPB"  name="bankcode" >

                                        </label></li>



                                </ul>

                            </div>
                        </li>
                        <li>
                            <label><input type="radio" value="VISA" name="option_payment" selected="true">Thanh toán bằng thẻ Visa hoặc MasterCard</label>
                            <div class="boxContent">
                                <p><span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:Visa hoặc MasterCard.</p>
                                <ul class="cardList clearfix">
                                        <li class="bank-online-methods ">
                                            <label for="vcb_ck_on">
                                                Visa:
                                                <input type="radio" value="VISA"  name="bankcode" >

                                        </label></li>

                                        <li class="bank-online-methods ">
                                            <label for="vnbc_ck_on">
                                                Master:<input type="radio" value="MASTER"  name="bankcode" >
                                        </label></li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                    <table style="clear:both;width:500px;padding-left:46px;">

                        <tr><td></td>
                            <td>
                                 <button type="submit" class="btn btn-primary">Thanh toán</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <hr>
    </div>
</section>
<!-- END Plans -->

<!-- Testimonials -->
<section class="site-content site-section">
    <div class="container">
        <div id="testimonials-carousel" class="carousel slide carousel-html" data-ride="carousel" data-interval="4000">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#testimonials-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#testimonials-carousel" data-slide-to="1"></li>
                <li data-target="#testimonials-carousel" data-slide-to="2"></li>
            </ol>
            <!-- END Indicators -->

            <!-- Wrapper for slides -->
            <div class="carousel-inner text-center">
                <div class="active item">
                    <p>
                        Tiện lợi
                    </p>
                    <blockquote class="no-symbol">
                        <p>Hình thức Thanh toán phong phú và đa dạng!</p>
                    </blockquote>
                </div>
                <div class="item">
                    <p>
                        An toàn
                    </p>
                    <blockquote class="no-symbol">
                        <p>Giao dịch được đảm bảo, tài khoản bảo mật!</p>
                    </blockquote>
                </div>
                <div class="item">
                    <p>
                        Dịch vụ chất lượng cao
                    </p>
                    <blockquote class="no-symbol">
                        <p>Nội dung luôn cập nhật sớm nhất, đáp ứng được yêu cầu!</p>
                    </blockquote>
                </div>
            </div>
            <!-- END Wrapper for slides -->
        </div>
        <hr>
    </div>
</section>
<!-- END Testimonials -->
<script type="text/javascript">
$(document).ready(function(){
    $('input[name="option_payment"]').bind('click', function() {
        $('.list-content li').removeClass('active');
        $(this).parent().parent('li').addClass('active');
    });
})
</script>
@stop