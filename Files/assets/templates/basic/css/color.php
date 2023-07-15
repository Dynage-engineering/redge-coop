<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color) {
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color or !checkhexcolor($color)) {
    $color = "#336699";
}


function checkhexcolor2($secondColor) {
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) and $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor or !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?>


.custom--cl, .service-card__icon i, .choose-card__icon i, .overview-card__icon i, .ratings i, .footer-info-list i, .header .main-menu li a:hover, .header .main-menu li a:focus, a:hover, .header .main-menu li.menu_has_children:hover > a::before, .plan-feature-list li::before, .bottom-menu ul li a:hover, .bottom-menu ul li a.active, .header .main-menu li a:hover, .header .main-menu li a:focus, .header .main-menu li a.active, .account-short-link li a:hover, .custom--checkbox input:checked~label::before,.btn-outline--base{
color: <?php echo $color; ?>;
}

.btn--base, plan-card__header, .bg--base, .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active, .dl__square, .plan-card__header,.copied::after{
background: <?php echo $color; ?>!important;
}

.feature-card i, .text--base, .page-breadcrumb li a:hover,.subscribe-form .form--control:focus ~ i,.dl__corner--top:before,
.dl__corner--top:after,
.dl__corner--bottom:before,
.dl__corner--bottom:after {
color: <?php echo $color; ?> !important;
}

.custom--bg, .feature-card::after, .testimonial-item, .section-top-title.border-left::before, .about-thumb .video-icon, .service-section, .how-work-card__step::before, .overview-section::after, .loan-card, .gradient--bg, .btn--gradient::before, .custom--accordion .accordion-button:not(.collapsed),
.btn-outline--gradient, .pagination .page-item.active .page-link,.btn-outline--base:hover {
background: <?php echo $color; ?>;
}

.overview-section, .testimonial-item::before, .header.menu-fixed .header__bottom, .footer, .account-wrapper .left, .btn--dark, .btn--dark:hover, .registration-wrapper .top-content, .btn--base-2, .custom--table thead, .account-section-right, .account-section-right::before, .account-section-right::after, .how-work-card__step, .btn-outline--gradient::before, .choose-card, .dark--overlay::before, .dark--overlay-two::before, .plan-card .fdr-badge{
background: <?php echo $secondColor; ?>;
}

.section--bg2 {
background-color: <?php echo $secondColor; ?>!important;
}

.custom--accordion .accordion-item, #preloader:before,.btn-outline--base {
border: 1px solid <?php echo $color; ?>;
}

.form--control:focus, .border--base, .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active, .expired-time-circle::before {
border-color: <?php echo $color; ?>!important
}

.custom--btn{
color: white;
background: <?php echo $color; ?>;
}

.btn:hover{
color: white;
}

.btn-primary{
background: <?php echo $color; ?>;
border-color: <?php echo $color; ?>;
}

.btn-primary:hover{
background: <?php echo $color; ?>;
border-color: <?php echo $color; ?>;
}

.header__bottom{
background-color: <?php echo $secondColor; ?>8c;
}

.pagination .page-item .page-link{
border: 1px solid <?php echo $color; ?>40;
}

.pagination .page-item .page-link:hover{
border: 1px solid <?php echo $color; ?>;
}

.pagination .page-item .page-link:hover, .header .main-menu li .sub-menu li a::before{
background-color: <?php echo $color; ?>;
}

.page-link:focus{
box-shadow: 0 0 0 0.25rem <?php echo $color; ?>40 !important;
}

.btn-check:focus+.btn-primary, .btn-primary:focus{
background-color: <?php echo $color; ?>;
border-color: <?php echo $color; ?> !important;
}

.header .main-menu li.menu_has_children > a::before, .contact-info-card__icon i{
color: <?php echo $color; ?>;
}

.header .main-menu li .sub-menu li a:hover, .page-breadcrumb li:first-child::before{
color: <?php echo $color; ?>;
}

.plan-card{
border-bottom: 3px solid <?php echo $color; ?>;
}

.service-card__icon {
background-color: <?php echo $color; ?>26 !important;
}
.feature-card .icon {
background-color: <?php echo $color; ?>26 !important;
}

.custom--accordion .accordion-button {
background-color: <?php echo $color; ?>0d;
}

.overview-card__icon i {
background: <?php echo $color; ?>;
background: -webkit-linear-gradient(-103deg, <?php echo $color; ?> 0%, <?php echo $color; ?> 35%, <?php echo $color; ?> 76%, <?php echo $color; ?> 100%);
background: linear-gradient(-103deg, <?php echo $color; ?> 0%, <?php echo $color; ?> 35%, <?php echo $color; ?> 76%, <?php echo $color; ?> 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
}

.section--bg {
background-color: <?php echo $color; ?>12;
}

@media (max-width: 991px) {
.header__bottom {
background-color: <?php echo $secondColor; ?>;
}
}

.account-form .form--control, .account-form .select {
background-color: <?php echo $secondColor; ?>ef;
}

.subscribe-section{
background-color: <?php echo $secondColor; ?>f7;
}

.form--control:focus ~ .input-group-text {
border-color: <?php echo $color; ?>;
}