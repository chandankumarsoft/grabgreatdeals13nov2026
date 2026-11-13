<style>
    .special-products .page-header {
        border-bottom: 0px #ddd solid;
        height: 14px;
        margin-top: 5px;
    }

    .special-price .price {
        font-size: 18px;
        color: #009698;
        font-weight: bold;
    }

    .old-price .price {
        font-size: 14px;
    }

    .halloween-left,
    .halloween-right {
        position: absolute;
    }

    .halloween-left a {
        display: block;
        margin: 15px 0px;
    }

    .halloween-right a {
        display: block;
        margin: 15px 0px;
    }


    .halloween-right img {
        width: 150px;
        margin: 0px 10px;
    }

    .halloween-left img {
        width: 150px;
        margin: 0px 10px;
    }

    .halloween-right {
        right: 0;
        text-align: right;
    }

    .halloween-left {
        left: 0;
        text-align: left;
    }

    @media only screen and (min-width:768px) and (max-width:1360px) {
        .halloween-right img {
            width: 75px;
            margin: 0px 10px;
        }

        .halloween-left img {
            width: 75px;
            margin: 0px 10px;
        }
    }
    @media only screen and (min-width:0px) and (max-width:777px) {
        .halloween-right img {
            display: none;
        }

        .halloween-left img {
           display: none;
        }
    }
</style>

<div class="halloween-left">
    <a href="<?php echo base_url() . '/product-details/halloween-female-ghost-wall-decal-removable-glass-window' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweenone.gif' ?>" alt="">
    </a>
    <a href="<?php echo base_url() . '/product-details/silicone-chocolate-baking-molds-halloween' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweenthree.gif' ?>" alt="">
    </a>
    <a href="<?php echo base_url() . '/product-details/glowing-in-the-dark-eyes-window-sticker-for-halloween' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweenfive.gif' ?>" alt="">
    </a>
    <a href="<?php echo base_url() . '/product-details/wizard-witch-prince-halloween-cloak' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweenseven.gif' ?>" alt="">
    </a>
</div>
<div class="halloween-right">
    <a href="<?php echo base_url() . '/product-details/gothic-elves-ear-cuff-piercing-cartilage-climber-ear-wrap-retro-silver-stud-earring-punk-hip-hop-clip-on-statement-earrings-gift' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweentwo.gif' ?>" alt="">
    </a>
    <a href="<?php echo base_url() . '/product-details/halloween-lights-led-candle-pumpkin-candlestick-lamp-scery-spider-happy-halloween-carnival-party-decoration-horror-props-2022' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweenfour.gif' ?>" alt="">
    </a>
    <a href="<?php echo base_url() . '/product-details/halloween-horror-bloodstain-scissors' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweensix.gif' ?>" alt="">
    </a>
    <a href="<?php echo base_url() . '/product-details/plague-doctor-mask-for-halloween' ?>">
        <img src="<?php echo base_url() . '/assets/front/images/halloween/halloweeneight.gif' ?>" alt="">
    </a>
</div>
<div class="container" id="featureProId" style="clear:both;">
    <div class="special-products">
        <div class="page-header">
            <div style="display:flex;">
                <h2 style="color: #009698;">halloween</h2>
                <a href="<?php echo base_url() . 'halloween/' ?>" style="font-weight: bold;font-size: medium;color:#555;text-decoration: underline;">See all deals</a>
            </div>
        </div>
        <div class="special-products-pro">
            <div class="slider-items-products">
                <div id="special-products-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col4">
                        <?php
                        $gethalloween = $this->ProductModel->get_halloween(); ?>
                        <?php foreach ($gethalloween as $halloweenValue) { ?>
                            <?php if ($halloweenValue->pro_status != 8) { ?>
                                <div class="product-item">
                                    <div class="item-inner">
                                        <div class="product-thumbnail">
                                            <div class="pr-img-area">
                                                <a title="<?php echo $halloweenValue->pro_title; ?>" href="<?php echo base_url() ?>product-details/<?php echo $halloweenValue->pro_title_slug; ?>">
                                                    <figure>
                                                        <img class="first-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $halloweenValue->pro_image ?>" alt="<?php echo $halloweenValue->pro_title; ?>">
                                                        <img class="hover-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $halloweenValue->pro_image ?>" alt="<?php echo $halloweenValue->pro_title; ?>">
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="pr-info-area">
                                                <div class="pr-button">
                                                    <div class="mt-button add_to_wishlist">
                                                        <a href="javascript:void(0)" class="wishlist_value_class" data-value="<?php echo $halloweenValue->pro_id; ?>">
                                                            <i class="fa fa-heart"></i>
                                                        </a>
                                                    </div>
                                                    <div class="mt-button quick-view"> <a href="<?php echo base_url() ?>product-quick/<?php echo $halloweenValue->pro_title_slug; ?>"> <i class="fa fa-search"></i> </a> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"> <a title="<?php echo $halloweenValue->pro_title; ?>" href="<?php echo base_url() ?>product-details/<?php echo $halloweenValue->pro_title_slug; ?>"><?php echo $halloweenValue->pro_title; ?></a> </div>
                                                <div class="item-content">
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
                                                        <span class="free-shipping">free shipping</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>