<style>
	.bee-row,
	.bee-row-content {
		position: relative
	}

	.bee-form .bee-form-row .bee-field button {
		font-size: inherit;
		font-family: inherit
	}

	body {
		background-color: #061624;
		color: #000;
		font-family: Oswald, Arial, Helvetica Neue, Helvetica, sans-serif
	}

	header {
		background-color: #ffffff;
	}

	a {
		color: #333e48
	}

	* {
		box-sizing: border-box
	}

	body,
	h1,
	h2,
	h3,
	p {
		margin: 0
	}

	.bee-row-content {
		max-width: 1440px;
		margin: 0 auto;
		display: flex
	}

	.bee-row-content.reverse,
	.bee-row-content.reverse .bee-col {
		-moz-transform: scale(1, -1);
		-webkit-transform: scale(1, -1);
		-o-transform: scale(1, -1);
		-ms-transform: scale(1, -1);
		transform: scale(1, -1)
	}

	.bee-row-content .bee-col-w2 {
		flex-basis: 17%
	}

	.bee-row-content .bee-col-w3 {
		flex-basis: 25%
	}

	.bee-row-content .bee-col-w4 {
		flex-basis: 33%
	}

	.bee-row-content .bee-col-w6 {
		flex-basis: 50%
	}

	.bee-row-16 .bee-col-4 .bee-block-3 div.label:not(.inline),
	.bee-row-16 .bee-col-4 .bee-block-3 label:not(.inline),
	.bee-row-content .bee-col-w12 {
		flex-basis: 100%
	}

	.bee-button .content {
		text-align: center
	}

	.bee-button a,
	.bee-icon .bee-icon-label-right a,
	.bee-menu ul li a {
		text-decoration: none
	}

	.bee-divider,
	.bee-image {
		overflow: auto
	}

	.bee-divider .center,
	.bee-image .bee-center {
		margin: 0 auto
	}

	.bee-row-13 .bee-col-2 .bee-block-1,
	.bee-row-13 .bee-col-3 .bee-block-1,
	.bee-row-13 .bee-col-4 .bee-block-1,
	.bee-row-13 .bee-col-5 .bee-block-1,
	.bee-row-15 .bee-col-1 .bee-block-4,
	.bee-row-16 .bee-col-4 .bee-block-3 .bee-form-row:not(.bee-sidelabel) input:not([type=checkbox]):not([type=radio]),
	.bee-row-5 .bee-col-1 .bee-block-1,
	.bee-row-5 .bee-col-3 .bee-block-1,
	.bee-row-7 .bee-col-1 .bee-block-1,
	.bee-row-7 .bee-col-2 .bee-block-1,
	.bee-row-7 .bee-col-3 .bee-block-1,
	.bee-row-7 .bee-col-4 .bee-block-1 {
		width: 100%
	}

	.bee-form .bee-form-row .bee-field {
		padding: 3px;
		display: flex;
		flex: 1;
		flex-wrap: wrap;
		align-items: center
	}

	.bee-form .bee-form-row .bee-field input:not([type=checkbox]):not([type=radio]) {
		flex-grow: 1;
		font-family: inherit;
		font-size: inherit
	}

	.bee-form .bee-form-row .bee-field .bee-button-container {
		flex-grow: 1
	}

	.bee-form input[type=color] {
		border: none;
		height: 38px
	}

	.bee-form input[type=color]::-webkit-color-sBUY-wrapper {
		margin: 0;
		padding: 2px
	}

	.bee-menu ul {
		margin: 0;
		padding: 0
	}

	.bee-form input[type=color]::-webkit-color-sBUY {
		margin: 0;
		padding: 0
	}

	.bee-icon {
		display: inline-block;
		vertical-align: middle
	}

	.bee-icon .bee-content {
		display: flex;
		align-items: center
	}

	.bee-image img {
		display: block;
		width: 100%
	}

	.bee-menu ul {
		list-style-type: none
	}

	.bee-menu ul.bee-horizontal li {
		display: inline-block
	}

	.bee-social .icon img {
		max-height: 32px
	}

	.bee-text {
		overflow-wrap: anywhere
	}

	.bee-row-1 {
		background-image: url('<?php echo base_url('assets/front/images/halloween/halloweeneight.gif'); ?>');
		background-repeat: repeat;
		background-position: center top
	}

	.bee-row-1 .bee-row-content,
	.bee-row-10 .bee-row-content,
	.bee-row-11 .bee-row-content,
	.bee-row-16 .bee-row-content,
	.bee-row-2 .bee-row-content,
	.bee-row-3 .bee-row-content,
	.bee-row-5 .bee-row-content,
	.bee-row-6 .bee-row-content,
	.bee-row-7 .bee-row-content,
	.bee-row-8 .bee-row-content,
	.bee-row-9 .bee-row-content {
		color: #000;
		background-repeat: no-repeat
	}

	.bee-row-1 .bee-col-1,
	.bee-row-10 .bee-col-1,
	.bee-row-10 .bee-col-2,
	.bee-row-11 .bee-col-1,
	.bee-row-17 .bee-col-1,
	.bee-row-8 .bee-col-1,
	.bee-row-9 .bee-col-1,
	.bee-row-9 .bee-col-2 {
		padding-bottom: 5px;
		padding-top: 5px
	}

	.bee-row-1 .bee-col-1 .bee-block-1,
	.bee-row-12 .bee-col-1 .bee-block-1,
	.bee-row-13 .bee-col-1 .bee-block-1,
	.bee-row-14 .bee-col-1 .bee-block-1,
	.bee-row-15 .bee-col-1 .bee-block-2,
	.bee-row-15 .bee-col-1 .bee-block-3,
	.bee-row-16 .bee-col-1 .bee-block-2,
	.bee-row-16 .bee-col-1 .bee-block-4,
	.bee-row-16 .bee-col-2 .bee-block-2,
	.bee-row-16 .bee-col-2 .bee-block-4,
	.bee-row-16 .bee-col-3 .bee-block-2,
	.bee-row-16 .bee-col-3 .bee-block-5,
	.bee-row-16 .bee-col-4 .bee-block-2,
	.bee-row-16 .bee-col-4 .bee-block-4,
	.bee-row-2 .bee-col-1 .bee-block-1,
	.bee-row-3 .bee-col-1 .bee-block-2,
	.bee-row-3 .bee-col-1 .bee-block-4,
	.bee-row-5 .bee-col-2 .bee-block-1,
	.bee-row-5 .bee-col-2 .bee-block-6,
	.bee-row-5 .bee-col-4 .bee-block-1,
	.bee-row-5 .bee-col-4 .bee-block-6,
	.bee-row-7 .bee-col-1 .bee-block-2,
	.bee-row-7 .bee-col-2 .bee-block-2,
	.bee-row-7 .bee-col-3 .bee-block-2,
	.bee-row-7 .bee-col-4 .bee-block-2 {
		padding: 10px
	}

	.bee-row-1 .bee-col-1 .bee-block-2 {
		padding-bottom: 10px;
		width: 100%
	}

	.bee-row-1 .bee-col-1 .bee-block-3 {
		text-align: center;
		color: #fff;
		font-family: inherit;
		font-size: 18px;
		letter-spacing: 1px
	}

	.bee-row-10,
	.bee-row-11,
	.bee-row-12,
	.bee-row-13,
	.bee-row-14,
	.bee-row-15,
	.bee-row-17,
	.bee-row-2,
	.bee-row-4,
	.bee-row-6,
	.bee-row-8,
	.bee-row-9 {
		background-repeat: no-repeat
	}

	.bee-row-2 .bee-col-1 .bee-block-2,
	.bee-row-5 .bee-col-2 .bee-block-8,
	.bee-row-5 .bee-col-4 .bee-block-8,
	.bee-row-7 .bee-col-1 .bee-block-8 {
		padding: 20px
	}

	.bee-row-3 {
		background-image: url('<?php echo base_url('assets/front/images/halloween/halloweenfive.gif'); ?>');
		background-repeat: no-repeat
	}

	.bee-row-3 .bee-col-1 {
		padding-left: 20px;
		padding-right: 20px
	}

	.bee-row-3 .bee-col-1 .bee-block-1 {
		padding: 15px 20px
	}

	.bee-row-13 .bee-col-1 .bee-block-2,
	.bee-row-3 .bee-col-1 .bee-block-3,
	.bee-row-8 .bee-col-1 .bee-block-2 {
		width: 100%;
		text-align: center;
		padding-right: 10px;
		padding-left: 10px
	}

	.bee-row-3 .bee-col-1 .bee-block-5,
	.bee-row-3 .bee-col-1 .bee-block-7 {
		padding: 15px
	}

	.bee-row-3 .bee-col-1 .bee-block-6,
	.bee-row-5 .bee-col-2 .bee-block-2,
	.bee-row-5 .bee-col-4 .bee-block-2,
	.bee-row-7 .bee-col-1 .bee-block-3,
	.bee-row-7 .bee-col-2 .bee-block-3,
	.bee-row-7 .bee-col-3 .bee-block-3,
	.bee-row-7 .bee-col-4 .bee-block-3 {
		width: 100%;
		text-align: center
	}

	.bee-row-3 .bee-col-1 .bee-block-8 {
		padding: 10px 15px
	}

	.bee-row-3 .bee-col-2 .bee-block-1 {
		width: 100%;
		padding-right: 10px;
		padding-left: 10px
	}

	.bee-row-15 .bee-row-content,
	.bee-row-17 .bee-row-content,
	.bee-row-4 .bee-row-content {
		background-repeat: no-repeat;
		color: #000
	}

	.bee-row-4 .bee-col-1 .bee-block-1 {
		padding: 30px 10px
	}

	.bee-row-4 .bee-col-1 .bee-block-2,
	.bee-row-6 .bee-col-1 .bee-block-1 {
		padding: 25px
	}

	.bee-row-5 .bee-col-2 .bee-block-3,
	.bee-row-5 .bee-col-2 .bee-block-4,
	.bee-row-5 .bee-col-2 .bee-block-5,
	.bee-row-5 .bee-col-4 .bee-block-3,
	.bee-row-5 .bee-col-4 .bee-block-4,
	.bee-row-5 .bee-col-4 .bee-block-5,
	.bee-row-7 .bee-col-1 .bee-block-4,
	.bee-row-7 .bee-col-1 .bee-block-5,
	.bee-row-7 .bee-col-2 .bee-block-4,
	.bee-row-7 .bee-col-2 .bee-block-5,
	.bee-row-7 .bee-col-3 .bee-block-4,
	.bee-row-7 .bee-col-3 .bee-block-5,
	.bee-row-7 .bee-col-4 .bee-block-4,
	.bee-row-7 .bee-col-4 .bee-block-5 {
		padding-top: 10px;
		padding-bottom: 10px
	}

	.bee-row-5 {
		background-image: url('<?php echo base_url('assets/front/images/halloween/halloweentwo.gif'); ?>');
		background-repeat: no-repeat;
		background-position: top center
	}

	.bee-row-13 .bee-col-1,
	.bee-row-13 .bee-col-2,
	.bee-row-13 .bee-col-3,
	.bee-row-13 .bee-col-4,
	.bee-row-13 .bee-col-5,
	.bee-row-5 .bee-col-1,
	.bee-row-5 .bee-col-3 {
		padding: 5px 20px
	}

	.bee-row-5 .bee-col-2,
	.bee-row-5 .bee-col-4 {
		padding: 5px 20px 5px 25px
	}

	.bee-row-5 .bee-col-2 .bee-block-7,
	.bee-row-5 .bee-col-4 .bee-block-7,
	.bee-row-7 .bee-col-1 .bee-block-7,
	.bee-row-7 .bee-col-2 .bee-block-7,
	.bee-row-7 .bee-col-3 .bee-block-7,
	.bee-row-7 .bee-col-4 .bee-block-7 {
		text-align: left
	}

	.bee-row-7 {
		background-image: url('<?php echo base_url('assets/front/images/halloween/halloweenfour.gif'); ?>');
		background-repeat: no-repeat;
		background-position: center top
	}

	.bee-row-7 .bee-col-1,
	.bee-row-7 .bee-col-2,
	.bee-row-7 .bee-col-3,
	.bee-row-7 .bee-col-4 {
		padding: 15px 20px 5px
	}

	.bee-row-7 .bee-col-1 .bee-block-6,
	.bee-row-7 .bee-col-2 .bee-block-6,
	.bee-row-7 .bee-col-3 .bee-block-6,
	.bee-row-7 .bee-col-4 .bee-block-6 {
		padding: 5px
	}

	.bee-row-8 .bee-col-1 .bee-block-1 {
		padding: 30px 10px 60px
	}

	.bee-row-8 .bee-col-1 .bee-block-3 {
		padding: 20px 10px 40px
	}

	.bee-row-10 .bee-col-1 .bee-block-1,
	.bee-row-10 .bee-col-2 .bee-block-1,
	.bee-row-10 .bee-col-3 .bee-block-1,
	.bee-row-10 .bee-col-4 .bee-block-1,
	.bee-row-16 .bee-col-1 .bee-block-1,
	.bee-row-16 .bee-col-2 .bee-block-1,
	.bee-row-16 .bee-col-3 .bee-block-1,
	.bee-row-16 .bee-col-4 .bee-block-1,
	.bee-row-9 .bee-col-1 .bee-block-1,
	.bee-row-9 .bee-col-2 .bee-block-1,
	.bee-row-9 .bee-col-3 .bee-block-1,
	.bee-row-9 .bee-col-4 .bee-block-1 {
		padding-top: 10px;
		padding-right: 10px;
		padding-left: 10px
	}

	.bee-row-10 .bee-col-1 .bee-block-2,
	.bee-row-10 .bee-col-2 .bee-block-2,
	.bee-row-10 .bee-col-3 .bee-block-2,
	.bee-row-10 .bee-col-4 .bee-block-2,
	.bee-row-13 .bee-col-2 .bee-block-3,
	.bee-row-13 .bee-col-3 .bee-block-3,
	.bee-row-13 .bee-col-4 .bee-block-3,
	.bee-row-13 .bee-col-5 .bee-block-3,
	.bee-row-9 .bee-col-1 .bee-block-2,
	.bee-row-9 .bee-col-2 .bee-block-2,
	.bee-row-9 .bee-col-3 .bee-block-2,
	.bee-row-9 .bee-col-4 .bee-block-2 {
		padding: 5px 20px 10px
	}

	.bee-row-10 .bee-col-3,
	.bee-row-10 .bee-col-4,
	.bee-row-9 .bee-col-3,
	.bee-row-9 .bee-col-4 {
		padding-top: 5px;
		padding-bottom: 5px
	}

	.bee-row-11 .bee-col-1 .bee-block-1 {
		text-align: center;
		padding-top: 40px;
		padding-bottom: 10px
	}

	.bee-row-11 .bee-col-1 .bee-block-2,
	.bee-row-15 .bee-col-1 .bee-block-1 {
		padding: 40px
	}

	.bee-row-12 .bee-row-content,
	.bee-row-13 .bee-row-content,
	.bee-row-14 .bee-row-content {
		background-color: #fff;
		color: #000;
		background-repeat: no-repeat
	}

	.bee-row-12 .bee-col-1,
	.bee-row-14 .bee-col-1 {
		padding-bottom: 5px;
		padding-top: 30px
	}

	.bee-row-13 .bee-col-1 .bee-block-3 {
		padding: 10px 25px
	}

	.bee-row-13 .bee-col-2 .bee-block-2,
	.bee-row-13 .bee-col-3 .bee-block-2,
	.bee-row-13 .bee-col-4 .bee-block-2,
	.bee-row-13 .bee-col-5 .bee-block-2 {
		padding: 5px 25px
	}

	.bee-row-15 .bee-col-1 .bee-block-5 {
		text-align: center;
		padding-top: 10px;
		padding-bottom: 15px
	}

	.bee-row-15 .bee-col-1 .bee-block-6 {
		padding: 60px 10px 30px
	}

	.bee-row-16 {
		background-image: url('<?php echo base_url('assets/front/images/halloween/halloweensix.gif'); ?>');
		background-repeat: repeat
	}

	.bee-row-16 .bee-col-1,
	.bee-row-16 .bee-col-2,
	.bee-row-16 .bee-col-3,
	.bee-row-16 .bee-col-4 {
		padding: 15px 10px
	}

	.bee-row-16 .bee-col-1 .bee-block-3,
	.bee-row-16 .bee-col-2 .bee-block-3,
	.bee-row-16 .bee-col-3 .bee-block-3 {
		padding: 5px 10px
	}

	.bee-row-16 .bee-col-3 .bee-block-4 {
		padding: 10px;
		text-align: left
	}

	.bee-row-16 .bee-col-4 .bee-block-3 {
		font-size: 16px;
		text-align: center;
		padding-right: 10px;
		padding-bottom: 10px;
		padding-left: 10px;
		font-family: inherit
	}

	.bee-row-17 .bee-col-1 .bee-block-1 {
		color: #9d9d9d;
		font-family: inherit;
		font-size: 15px;
		padding-bottom: 5px;
		padding-top: 5px;
		text-align: center
	}

	.bee-row-1 .bee-col-1 .bee-block-3 li {
		padding: 5px 15px
	}

	.bee-row-1 .bee-col-1 .bee-block-3 li a {
		color: #fff
	}

	@media (max-width:768px) {
		.bee-form form {
			width: 100% !important
		}

		.bee-row-content:not(.no_stack) {
			display: block
		}
	}

	.bee-row-17 .bee-col-1 .bee-block-1 .bee-icon-image {
		padding: 5px 6px 5px 5px
	}

	.bee-row-16 .bee-col-4 .bee-block-3 {
		text-align: "center"
	}

	.bee-row-16 .bee-col-4 .bee-block-3 form {
		display: inline-block;
		width: 100%
	}

	.bee-row-16 .bee-col-4 .bee-block-3 div.label,
	.bee-row-16 .bee-col-4 .bee-block-3 label {
		color: #fff;
		line-height: 200%;
		text-align: left;
		display: block
	}

	.bee-row-16 .bee-col-4 .bee-block-3 ::-webkit-input-placeholder {
		color: #0b3e5c
	}

	.bee-row-16 .bee-col-4 .bee-block-3 :-moz-placeholder {
		color: #0b3e5c
	}

	.bee-row-16 .bee-col-4 .bee-block-3 ::-moz-placeholder {
		color: #0b3e5c
	}

	.bee-row-16 .bee-col-4 .bee-block-3 :-ms-input-placeholder {
		color: #0b3e5c
	}

	.bee-row-16 .bee-col-4 .bee-block-3 .bee-field>label:first-child,
	.bee-row-16 .bee-col-4 .bee-block-3 div.label {
		padding: 3px
	}

	.bee-row-16 .bee-col-4 .bee-block-3 input:not([type=checkbox]):not([type=radio]):not([type=image]) {
		color: #0b3e5c;
		background-color: #fff;
		border-top: 1px solid transparent;
		border-right: 1px solid transparent;
		border-bottom: 1px solid transparent;
		border-left: 1px solid transparent;
		padding: 5px;
		border-radius: 4px;
		min-height: 42px
	}

	.bee-row-16 .bee-col-4 .bee-block-3 input:not([type=checkbox]):not([type=radio]):focus {
		outline-color: #3aaee0
	}

	.bee-row-16 .bee-col-4 .bee-block-3 button {
		background-color: #ff0004;
		border-radius: 0;
		border-top: 0 solid #fff;
		border-right: 0px solid #fff;
		border-bottom: 0 solid #fff;
		border-left: 0 solid #fff;
		color: #fff;
		line-height: 200%;
		width: 100%;
		padding: 5px 20px
	}

	.bee-row-16 .bee-col-4 .bee-block-3 .bee-button-container {
		padding-top: 5px;
		text-align: "center"
	}

	.owl-buttons {
		display: none;
	}

	.owl-carousel:hover .owl-buttons {
		display: block;
	}

	.owl-theme .owl-controls .owl-buttons div {
		background: transparent;
		color: #869791;
		font-size: 40px;
		line-height: 300px;
		margin: 0;
		padding: 0 60px;
		position: absolute;
		top: 0;
	}

	.owl-theme .owl-controls .owl-buttons .owl-prev {
		left: 0;
		padding-left: 20px;
	}

	.owl-theme .owl-controls .owl-buttons .owl-next {
		right: 0;
		padding-right: 20px;
	}

	.special-price .price {
		font-size: 20px;
		color: #fed700;
		font-weight: bold;
	}

	.price {
		font-size: 28px;
		color: #fed700;
		font-weight: bold;
	}

	.old-price .price {
		color: #fff !important;
		font-size: 15px;
		font-weight: normal;
		text-decoration: line-through;
		margin-left: 6px;
	}
</style>
<div class="bee-row bee-row-2">
	<div class="bee-row-content">
		<div class="bee-col bee-col-1 bee-col-w12">
			<div class="bee-block bee-block-1 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
			<div class="bee-block bee-block-2 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="bee-row bee-row-3">
	<div class="bee-row-content reverse">
		<div class="bee-col bee-col-1 bee-col-w6">
			<div class="bee-block bee-block-1 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
			<div class="bee-block bee-block-2 bee-divider">
				<div class="center bee-separator" style="border-top:1px solid #FFFFFF;width:50%;"></div>
			</div>
			<div class="bee-block bee-block-3 bee-heading">
				<h2 style="color:#ffffff;font-size:20px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:center;direction:ltr;font-weight:normal;letter-spacing:1px;margin-top:0;margin-bottom:0;">YOU WILL NOT SLEEP </h2>
			</div>
			<div class="bee-block bee-block-4 bee-divider">
				<div class="center bee-separator" style="border-top:1px solid #FFFFFF;width:50%;"></div>
			</div>
			<div class="bee-block bee-block-5 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
			<?php $dbselc = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc')->from('tbl_product')->where('pro_id', 1667)->get()->row(); ?>
			<div class="bee-block bee-block-6 bee-heading">
				<h1 style="color:#ff0004;font-size:40px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:center;direction:ltr;font-weight:normal;letter-spacing:1px;margin-top:0;margin-bottom:0;"><a href="<?php echo base_url() . 'product-details/' . $dbselc->pro_title_slug; ?>" style="color:#ff0004;"><?php echo $dbselc->pro_title; ?></a></h1>
			</div>
			<div class="bee-block bee-block-7 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
			<div class="bee-block bee-block-8 bee-text">
				<div class="bee-text-content" style="font-size: 15px; line-height: 150%; color: #ffffff; font-family: inherit;">
					<p style="font-size: 14px; line-height: 21px; text-align: center;">
						<?php echo substr(legacy_localize_content_urls($dbselc->pro_desc), 0, 600); ?>
					</p>
				</div>
			</div>
			<div class="bee-block bee-block-7 bee-button">
				<a href="<?php echo base_url() ?>product-details/<?php echo $dbselc->pro_title_slug; ?>" class="btn btn-warning" style="width:100%;">BUY NOW</a>
			</div>
		</div>
		<div class="bee-col bee-col-2 bee-col-w6">
			<div class="bee-block bee-block-1 bee-image"><img alt="Image of Header" class="bee-center bee-autowidth" src="https://www.seller.grabgreatdeals.com/uploads/166384296060200.gif" style="max-width:700px;" /></div>
		</div>
	</div>
</div>
<div class="bee-row bee-row-7">
	<div class="bee-row-content">
		<div id="owlc1" class="owl-carousel">
			<?php
			$gethalloween = $this->ProductModel->get_halloween(); ?>
			<?php foreach ($gethalloween as $halloweenValue) { ?>
				<?php if ($halloweenValue->pro_status != 8) { ?>
					<div class="bee-col bee-col-1 bee-col-w3">
						<div class="bee-block bee-block-1 bee-image"><img alt="<?php echo $halloweenValue->pro_title; ?>" class="bee-center bee-autowidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $halloweenValue->pro_image ?>" style="max-width:320px;" /></div>
						<div class="bee-block bee-block-2 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-3 bee-heading">
							<h3 style="color:#fffc00;font-size:20px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0; overflow: hidden; text-overflow: ellipsis;white-space: nowrap;width: 200px;"><strong><?php echo $halloweenValue->pro_title; ?></strong> </h3>
						</div>
						<div class="bee-block bee-block-4 bee-text">
							<div class="bee-text-content" style="line-height: 120%; font-size: 12px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff;">
								<div class="item-price">
									<?php if (!empty($halloweenValue->pro_offer_price)) { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_offer_price); ?> </span> </p>
											<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } else { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="bee-block bee-block-5 bee-divider">
							<div class="left bee-separator" style="border-top:1px solid #FFFFFF;width:100%;"></div>
						</div>
						<div class="bee-block bee-block-6 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-7 bee-button">
							<a href="<?php echo base_url() ?>product-details/<?php echo $halloweenValue->pro_title_slug; ?>" class="btn btn-warning" style="width:100%;">BUY NOW</a>
						</div>
						<div class="bee-block bee-block-8 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
					</div>
			<?php }
			} ?>
		</div>
	</div>
</div>
<div class="bee-row bee-row-4">
	<div class="bee-row-content">
		<div class="bee-col bee-col-1 bee-col-w12">
			<div class="bee-block bee-block-1 bee-divider">
				<div class="center bee-separator" style="border-top:1px solid #FFFFFF;width:100%;"></div>
			</div>
			<div class="bee-block bee-block-2 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
		</div>
	</div>
</div>
<div class="bee-row bee-row-5">
	<div class="bee-row-content">
		<?php $dbselc1 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where_in('pro_id', [1667, 1664])->get()->result(); ?>
		<?php foreach ($dbselc1 as $dbselc1value) { ?>
			<div class="bee-col bee-col-1 bee-col-w3">
				<div class="bee-block bee-block-1 bee-image"><img alt="Movie: The Shining" class="bee-center bee-autowidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc1value->pro_image ?>" style="max-width:320px;" /></div>
			</div>
			<div class="bee-col bee-col-2 bee-col-w3">
				<div class="bee-block bee-block-1 bee-divider">
					<div class="spacer" style="height:0px;"></div>
				</div>
				<div class="bee-block bee-block-2 bee-heading">
					<h3 style="color:#fffc00;font-size:20px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo $dbselc1value->pro_title; ?></strong> </h3>
				</div>
				<div class="bee-block bee-block-3 bee-text">
					<div class="bee-text-content" style="line-height: 120%; font-size: 12px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff;">
						<div class="item-price">
							<?php if (!empty($dbselc1value->pro_offer_price)) { ?>
								<div class="price-box">
									<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc1value->pro_offer_price); ?> </span> </p>
									<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc1value->pro_price); ?> </span> </p>
								</div>
							<?php } else { ?>
								<div class="price-box">
									<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc1value->pro_price); ?> </span> </p>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="bee-block bee-block-4 bee-divider">
					<div class="left bee-separator" style="border-top:1px solid #FFFFFF;width:50%;"></div>
				</div>
				<div class="bee-block bee-block-5 bee-text">
					<div class="bee-text-content" style="line-height: 120%; font-size: 15px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff; ">
						<p style="font-size: 14px; line-height: 16px; text-align: left;"><?php echo substr(legacy_localize_content_urls($dbselc1value->pro_desc), 0, 600); ?></p>
					</div>
				</div>
				<div class="bee-block bee-block-6 bee-divider">
					<div class="spacer" style="height:0px;"></div>
				</div>
				<div class="bee-block bee-block-7 bee-button">
					<div class="bee-button-content" style="font-size: 12px; line-height: 24px; font-family: inherit; background-color: #fed700; border-radius: 0px; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; color: #ffffff; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;"><span style="font-size: 18px; line-height: 36px;"><a href="<?php echo base_url() ?>product-details/<?php echo $dbselc1value->pro_title_slug; ?>" class="btn btn-warning" style="width:100%;">BUY NOW</a></span></span></div>
				</div>
				<div class="bee-block bee-block-8 bee-divider">
					<div class="spacer" style="height:0px;"></div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<div class="bee-row bee-row-6">
	<div class="bee-row-content">
		<div class="bee-col bee-col-1 bee-col-w12">
			<div class="bee-block bee-block-1 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
		</div>
	</div>
</div>
<div class="bee-row bee-row-7">
	<div class="bee-row-content">
		<div id="owlc1" class="owl-carousel">
			<?php
			$gethalloween = $this->ProductModel->get_halloween(); ?>
			<?php foreach ($gethalloween as $halloweenValue) { ?>
				<?php if ($halloweenValue->pro_status != 8) { ?>
					<div class="bee-col bee-col-1 bee-col-w3">
						<div class="bee-block bee-block-1 bee-image"><img alt="<?php echo $halloweenValue->pro_title; ?>" class="bee-center bee-autowidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $halloweenValue->pro_image ?>" style="max-width:320px;" /></div>
						<div class="bee-block bee-block-2 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-3 bee-heading">
							<h3 style="color:#fffc00;font-size:20px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0; overflow: hidden; text-overflow: ellipsis;white-space: nowrap;width: 200px;"><strong><?php echo $halloweenValue->pro_title; ?></strong> </h3>
						</div>
						<div class="bee-block bee-block-4 bee-text">
							<div class="bee-text-content" style="line-height: 120%; font-size: 12px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff;">
								<div class="item-price">
									<?php if (!empty($halloweenValue->pro_offer_price)) { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_offer_price); ?> </span> </p>
											<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } else { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="bee-block bee-block-5 bee-divider">
							<div class="left bee-separator" style="border-top:1px solid #FFFFFF;width:100%;"></div>
						</div>
						<div class="bee-block bee-block-6 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-7 bee-button">
							<a href="<?php echo base_url() ?>product-details/<?php echo $halloweenValue->pro_title_slug; ?>" class="btn btn-warning" style="width:100%;">BUY NOW</a>
						</div>
						<div class="bee-block bee-block-8 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
					</div>
			<?php }
			} ?>
		</div>
	</div>
</div>
<div class="bee-row bee-row-6">
	<div class="bee-row-content">
		<div class="bee-col bee-col-1 bee-col-w12">
			<div class="bee-block bee-block-1 bee-divider">
				<div class="spacer" style="height:0px;"></div>
			</div>
		</div>
	</div>
</div>
<div class="bee-row bee-row-5">
	<div class="bee-row-content">
		<?php $dbselc1 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where_in('pro_id', [1667, 1664])->get()->result(); ?>
		<?php foreach ($dbselc1 as $dbselc1value) { ?>
			<div class="bee-col bee-col-1 bee-col-w3">
				<div class="bee-block bee-block-1 bee-image"><img alt="Movie: The Shining" class="bee-center bee-autowidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc1value->pro_image ?>" style="max-width:320px;" /></div>
			</div>
			<div class="bee-col bee-col-2 bee-col-w3">
				<div class="bee-block bee-block-1 bee-divider">
					<div class="spacer" style="height:0px;"></div>
				</div>
				<div class="bee-block bee-block-2 bee-heading">
					<h3 style="color:#fffc00;font-size:20px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo $dbselc1value->pro_title; ?></strong> </h3>
				</div>
				<div class="bee-block bee-block-3 bee-text">
					<div class="bee-text-content" style="line-height: 120%; font-size: 12px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff;">
						<div class="item-price">
							<?php if (!empty($dbselc1value->pro_offer_price)) { ?>
								<div class="price-box">
									<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc1value->pro_offer_price); ?> </span> </p>
									<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc1value->pro_price); ?> </span> </p>
								</div>
							<?php } else { ?>
								<div class="price-box">
									<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc1value->pro_price); ?> </span> </p>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="bee-block bee-block-4 bee-divider">
					<div class="left bee-separator" style="border-top:1px solid #FFFFFF;width:50%;"></div>
				</div>
				<div class="bee-block bee-block-5 bee-text">
					<div class="bee-text-content" style="line-height: 120%; font-size: 15px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff; ">
						<p style="font-size: 14px; line-height: 16px; text-align: left;"><?php echo substr(legacy_localize_content_urls($dbselc1value->pro_desc), 0, 600); ?></p>
					</div>
				</div>
				<div class="bee-block bee-block-6 bee-divider">
					<div class="spacer" style="height:0px;"></div>
				</div>
				<div class="bee-block bee-block-7 bee-button">
					<div class="bee-button-content" style="font-size: 12px; line-height: 24px; font-family: inherit; background-color: #fed700; border-radius: 0px; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; color: #ffffff; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;"><span style="font-size: 18px; line-height: 36px;"><a href="<?php echo base_url() ?>product-details/<?php echo $dbselc1value->pro_title_slug; ?>" class="btn btn-warning" style="width:100%;">BUY NOW</a></span></span></div>
				</div>
				<div class="bee-block bee-block-8 bee-divider">
					<div class="spacer" style="height:0px;"></div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<div class="bee-row bee-row-7">
	<div class="bee-row-content">
		<div id="owlc1" class="owl-carousel">
			<?php
			$gethalloween = $this->ProductModel->get_halloween(); ?>
			<?php foreach ($gethalloween as $halloweenValue) { ?>
				<?php if ($halloweenValue->pro_status != 8) { ?>
					<div class="bee-col bee-col-1 bee-col-w3">
						<div class="bee-block bee-block-1 bee-image"><img alt="<?php echo $halloweenValue->pro_title; ?>" class="bee-center bee-autowidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $halloweenValue->pro_image ?>" style="max-width:320px;" /></div>
						<div class="bee-block bee-block-2 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-3 bee-heading">
							<h3 style="color:#fffc00;font-size:20px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0; overflow: hidden; text-overflow: ellipsis;white-space: nowrap;width: 200px;"><strong><?php echo $halloweenValue->pro_title; ?></strong> </h3>
						</div>
						<div class="bee-block bee-block-4 bee-text">
							<div class="bee-text-content" style="line-height: 120%; font-size: 12px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff;">
								<div class="item-price">
									<?php if (!empty($halloweenValue->pro_offer_price)) { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_offer_price); ?> </span> </p>
											<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } else { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="bee-block bee-block-5 bee-divider">
							<div class="left bee-separator" style="border-top:1px solid #FFFFFF;width:100%;"></div>
						</div>
						<div class="bee-block bee-block-6 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-7 bee-button">
							<a href="<?php echo base_url() ?>product-details/<?php echo $halloweenValue->pro_title_slug; ?>" class="btn btn-warning" style="width:100%;">BUY NOW</a>
						</div>
						<div class="bee-block bee-block-8 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
					</div>
			<?php }
			} ?>
		</div>
	</div>
</div>
<div class="bee-row bee-row-7">
	<div class="bee-row-content">
		<div id="owlc1" class="owl-carousel">
			<?php
			$gethalloween = $this->ProductModel->get_halloween(); ?>
			<?php foreach ($gethalloween as $halloweenValue) { ?>
				<?php if ($halloweenValue->pro_status != 8) { ?>
					<div class="bee-col bee-col-1 bee-col-w3">
						<div class="bee-block bee-block-1 bee-image"><img alt="<?php echo $halloweenValue->pro_title; ?>" class="bee-center bee-autowidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $halloweenValue->pro_image ?>" style="max-width:320px;" /></div>
						<div class="bee-block bee-block-2 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-3 bee-heading">
							<h3 style="color:#fffc00;font-size:20px;font-family:Oswald, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0; overflow: hidden; text-overflow: ellipsis;white-space: nowrap;width: 200px;"><strong><?php echo $halloweenValue->pro_title; ?></strong> </h3>
						</div>
						<div class="bee-block bee-block-4 bee-text">
							<div class="bee-text-content" style="line-height: 120%; font-size: 12px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #ffffff;">
								<div class="item-price">
									<?php if (!empty($halloweenValue->pro_offer_price)) { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_offer_price); ?> </span> </p>
											<p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } else { ?>
										<div class="price-box">
											<p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($halloweenValue->pro_price); ?> </span> </p>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="bee-block bee-block-5 bee-divider">
							<div class="left bee-separator" style="border-top:1px solid #FFFFFF;width:100%;"></div>
						</div>
						<div class="bee-block bee-block-6 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
						<div class="bee-block bee-block-7 bee-button">
							<a href="<?php echo base_url() ?>product-details/<?php echo $halloweenValue->pro_title_slug; ?>" class="btn btn-warning" style="width:100%;">BUY NOW</a>
						</div>
						<div class="bee-block bee-block-8 bee-divider">
							<div class="spacer" style="height:0px;"></div>
						</div>
					</div>
			<?php }
			} ?>
		</div>
	</div>
</div>
</div>
<script>
	$(document).ready(function() {

		$("#owlc1,#owlc2").owlCarousel({
			itemsDesktop: [1499, 4],
			itemsDesktopSmall: [1199, 3],
			itemsTablet: [899, 2],
			itemsMobile: [599, 1],
			navigation: true,
			loop: true,
			pagination: false,
			// autoPlay: true,

			// autoplayTimeout: 1000,
			navigationText: ['<span class="fa-stack"><i class="fa fa-circle fa-stack-1x"></i><i class="fa fa-chevron-circle-left fa-stack-1x fa-inverse"></i></span>', '<span class="fa-stack"><i class="fa fa-circle fa-stack-1x"></i><i class="fa fa-chevron-circle-right fa-stack-1x fa-inverse"></i></span>'],
		});
		var owl = $('.test');
		owl.owlCarousel();
		// Listen to owl events:
		owl.on('click', function(event) {
			alert("Slider Changed");
		});

	});
</script>