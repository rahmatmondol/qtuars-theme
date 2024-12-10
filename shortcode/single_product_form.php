<?php

add_shortcode('checkout_form', 'custom_shortcode_function');
function custom_shortcode_function()
{
    // get product id
    $productId      = get_the_ID();
    $product        = wc_get_product($productId);
    $meeting_points = get_field('meeting_points', $productId);
    $type           = get_field('product_type', $productId);
    $minimum_guest  = get_field('minimum_guest', $productId) ?? 0;
    $variations     = $product->is_type('variable') ? $product->get_available_variations() : [];
    $add_ons        = get_field('add-ons', $productId);
    $child          = get_field('child', $productId);
    $adult          = get_field('adult', $productId);
    $private        = get_field('private', $productId);
    ob_start();
    ?>
<div class="checkout-form">
    <form method="post" action="" id="checkout_form">
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
        </div>
        <div class="form-group mt-3">
            <input type="text" class="form-control" id="company_name" name="company_name"
                placeholder="Company Name (if applicable)">
        </div>
        <div class="form-group mt-3">
            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number*"
                required>
        </div>
        <div class="form-group mt-3">
            <label for="email">Email</label>
            <input type="email" class="form-control mt-2" id="email" name="email" placeholder="Email*" required>
        </div>
        <div class="form-group mt-3">
            <label for="date">Date</label>
            <input type="date" class="form-control mt-2" id="date" name="date" placeholder="Date" required>
        </div>
        <div class="form-group mt-3">
            <label for="time">Time</label>
            <input type="time" class="form-control mt-2" id="time" name="time" placeholder="Time" required>
        </div>
        <div class="form-group mt-3">
            <label for="time">Select meeting point</label>
            <select class="form-select mt-2" name="meeting_point" aria-label="Default select example">
                <option selected disabled>Select meeting point</option>
                <?php
                        if ($meeting_points) {
                            foreach ($meeting_points as $meeting_point) {
                                echo '<option value="' . $meeting_point . '">' . $meeting_point . '</option>'; 
                            }
                        }
                    ?>
            </select>
        </div>

        <div class="mt-5 duration-variation-group">
            <h4 class="age-title">Please Select</h4>
            <div class="persons d-flex flex-wrap gap-2 gap-md-5 flex-column flex-md-row">
                <?php if ($adult) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input Adult" data-price="<?php echo $adult; ?>" id="adult_price"
                        type="checkbox" name="Adult" value="<?php echo $adult; ?>">
                    <label class="form-check-label" for="adult_price">
                        Adult
                        <?php echo $adult; ?>
                        OMR
                    </label>
                </div>
                <?php endif; ?>
                <?php if ($child) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input Child" data-price="<?php echo $child; ?>" id="Child_price"
                        type="checkbox" name="Child" value="<?php echo $child; ?>">
                    <label class="form-check-label" for="Child_price">
                        Child
                        <?php echo $child; ?>
                        OMR
                    </label>
                </div>
                <?php endif; ?>
                <?php if ($private) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input Private" data-price="<?php echo $private; ?>" id="private_price"
                        type="checkbox" name="Private" value="<?php echo $private; ?>">
                    <label class="form-check-label" for="private_price">
                        Private
                        <?php echo $private; ?>
                        OMR
                    </label>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mt-5">
            <h4 class="age-title">No. of Guests
                <?php echo $minimum_guest > 0 ? '( ' . $minimum_guest . ' guests minimum )': '' ?>
            </h4>
            <div class="col-md-3">
                <div class="form-group age-group mt-3 mb-md-5">
                    <label for="age">Adult age 12+</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="decreaseAdult">-</button>
                        </div>
                        <input type="text" class="form-control" id="adult" name="adult_count" value="0" readonly>
                        <div class="input-group-append">
                            <button type="button" class="increaseAdult">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group age-group mt-3 mb-md-5">
                    <label for="age">Child age 3-11</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="decreaseChild">-</button>
                        </div>
                        <input type="text" class="form-control" id="child" name="child_count" value="0" readonly>
                        <div class="input-group-append">
                            <button type="button" class="increaseChild">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php if ($type) : ?>
        <div class="form-group age-group mt-3 mb-5">
            <label for="age">Age</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="decreaseAge">-</button>
                </div>
                <input type="text" class="form-control" id="age" name="age" placeholder="Age" value="0" readonly>
                <div class="input-group-append">
                    <button type="button" class="increaseAge">+</button>
                </div>
            </div>
        </div>

        <hr />
        <h3 class="document-title">Upload verification Documents</h3>
        <div class="row">
            <div class="col-4">
                <div class="form-group mt-3">
                    <label for="driver_license" class="form-label">Diver's License <span class="text-danger">*certified
                            divers only</span></label>
                    <div class="input-group">
                        <div class="custom-file">
                            <label class="custom-file-label" for="diver_license">Choose file</label>
                            <input type="file" class="custom-file-input" id="diver_license" name="diver_license"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group mt-3">
                    <label for="driver_license" class="form-label">Driver's Passport <span
                            class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="custom-file">
                            <label class="custom-file-label" for="driver_passport">Choose file</label>
                            <input type="file" class="custom-file-input" id="driver_passport" name="driver_passport"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group mt-3">
                    <button type="submit" class="add-to-cart">Add to Cart</button>
                    <span class="price" id="main_price">
                        <?php echo $product->get_price(); ?>
                    </span>
                    OMR
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $productId; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mt-3">
                    <button type="button" id="add-to-wishlist" class="add-to-cart">Add to wishlist <i
                            class="fa-regular fa-heart"></i></button>
                </div>
            </div>
        </div>

        <?php if($add_ons) : ?>
        <div class="row mb-5 addons-group-container">
            <h4 class="age-title">Customize your Camping trip and Select ADD-ONS</h4>
            <div class="col-md-4">
                <div class="form-group mt-3 addon-group">
                    <?php foreach ($add_ons as $addon) : ?>
                    <div class="form-check">
                        <label class="form-check-label" for="addon-<?php echo $addon->ID; ?>">
                            <h5 class="addon-title">
                                <?php echo $addon->post_title; ?>
                            </h5>
                            <p>
                                <?php echo $addon->post_content; ?>
                            </p>
                            <span class="price">
                                <?php echo wc_get_product($addon->ID)->get_price(); ?>OMR
                            </span>
                        </label>
                        <input class="form-check-input add-ons"
                            data-price="<?php echo wc_get_product($addon->ID)->get_price(); ?>" type="checkbox"
                            value="<?php echo $addon->ID; ?>" id="addon-<?php echo $addon->ID; ?>" name="addons[]">

                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <hr />

    </form>
</div>


<script>
    //jQuery ready start
    jQuery(document).ready(function ($) {

        // Function to update the total price
        function updatePrice() {
            const basePrice = parseFloat('<?php echo $product->get_price(); ?>');
            let totalPrice = basePrice;

            // Add prices for all checked Child checkboxes
            $('.Child:checked').each(function () {
                const count = parseInt($('#child').val(), 10) || 0;
                const price = parseFloat($(this).data('price')) || 0;
                totalPrice += count * price;
            });

            // Add prices for all checked Adult checkboxes
            $('.Adult:checked').each(function () {
                const count = parseInt($('#adult').val(), 10) || 0;
                const price = parseFloat($(this).data('price')) || 0;
                totalPrice += count * price;
            });

            // Add prices for all checked Private checkboxes
            $('.Private:checked').each(function () {
                const price = parseFloat($(this).data('price')) || 0;
                totalPrice += price;
            });

            // Update the displayed price
            $('#main_price').text(totalPrice.toFixed(2));
        }

        // Handle changes to the Child checkbox
        $(document).on('change', '.Child', function () {
            const isChecked = $(this).is(':checked');
            let childCount = parseInt($('#child').val()) || 0;

            // Adjust child count based on checkbox state
            $('#child').val(isChecked ? Math.max(1, childCount) : 0);

            // Update the total price
            updatePrice();
        });

        // Handle changes to the Adult checkbox
        $(document).on('change', '.Adult', function () {
            const isChecked = $(this).is(':checked');
            let adultCount = parseInt($('#adult').val()) || 0;

            // Adjust adult count based on checkbox state
            $('#adult').val(isChecked ? Math.max(1, adultCount) : 0);

            // Update the total price
            updatePrice();
        });

        // Handle changes to the Private checkbox
        $(document).on('change', '.Private', function () {
            updatePrice();
        });

        // Handle increaseChild button click
        $('.increaseChild').click(function () {
            let childCount = parseInt($('#child').val()) || 0;

            // Check the .Child checkbox if not already checked
            if (!$('.Child').is(':checked')) {
                $('.Child').prop('checked', true);
                childCount = 1; // Reset count to 1 when checked
            } else {
                childCount += 1; // Increment count if already checked
            }

            // Update child count and price
            $('#child').val(childCount);
            updatePrice();
        });

        // Handle decreaseChild button click
        $('.decreaseChild').click(function () {
            let childCount = parseInt($('#child').val()) || 0;

            if (childCount > 1) {
                // Decrease the count if it's greater than 1
                childCount -= 1;
            } else {
                // Uncheck the .Child checkbox if count reaches 0
                childCount = 0;
                $('.Child').prop('checked', false);
            }

            // Update child count and price
            $('#child').val(childCount);
            updatePrice();
        });

        // Handle increaseAdult button click
        $('.increaseAdult').click(function () {
            let adultCount = parseInt($('#adult').val()) || 0;

            // Check the .Adult checkbox if not already checked
            if (!$('.Adult').is(':checked')) {
                $('.Adult').prop('checked', true);
                adultCount = 1; // Reset count to 1 when checked
            } else {
                adultCount += 1; // Increment count if already checked
            }

            // Update adult count and price
            $('#adult').val(adultCount);
            updatePrice();
        });

        // Handle decreaseAdult button click
        $('.decreaseAdult').click(function () {
            let adultCount = parseInt($('#adult').val()) || 0;

            if (adultCount > 1) {
                // Decrease the count if it's greater than 1
                adultCount -= 1;
            } else {
                // Uncheck the .Adult checkbox if count reaches 0
                adultCount = 0;
                $('.Adult').prop('checked', false);
            }

            // Update adult count and price
            $('#adult').val(adultCount);
            updatePrice();
        });


        $('.increaseAge').click(function () {
            var age = $('#age').val();
            $('#age').val(parseInt(age) + 1);
        });

        $('.decreaseAge').click(function () {
            var age = $('#age').val();
            if (age > 0) {
                $('#age').val(parseInt(age) - 1);
            }
        });

        //add to cart
        $("#checkout_form").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'qtuars_add_to_cart');

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    alert('Something went wrong');
                }
                });
    });

    //add to wishlist
    $("#add-to-wishlist").on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: '<?php echo admin_url('admin- ajax.php'); ?>',
            type: 'post',
            data: {
            action: 'qtuars_add_to_wishlist',
            product_id: $('#product_id').val()
        },
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                alert('Something went wrong');
            }
                });
            });
        });


</script>

<style>
    .form-select,
    .form-control {
        background: #f4f3f3;
        padding: 12px !important;
        border-color: #cacaca !important;
        border-radius: 0px !important;
    }


    .form-group.age-group {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .form-group.age-group .form-control {
        background: transparent;
        border: none;
        border-top-color: currentcolor;
        border-right-color: currentcolor;
        border-bottom-color: currentcolor;
        border-left-color: currentcolor;
        min-width: 50px !important;
        flex: inherit;
        font-size: 26px;
        padding: 0px 10px !important;
        text-align: center;
    }


    .input-group-append button,
    .input-group-prepend button {
        border-color: #949494;
        border-radius: 30px;
        font-size: 25px;
        color: #000;
        height: 40px;
        display: flex;
        align-items: end;
        width: 42px;
        justify-content: center;
        padding: 4px;
    }

    .input-group-append button:hover,
    .input-group-prepend button:hover {
        background: #2e464a;
        color: #fff;
    }

    .document-title {
        font-family: "Lato", Sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: #2e464a;
        margin-top: 20px;
    }

    .custom-file-label {
        background: #404040;
        color: #c8c8c8;
        padding: 12px 30px;
        border-radius: 10px;
        cursor: pointer;
    }

    .custom-file-input {
        margin-left: 61px;
        position: relative;
        z-index: -1;
        top: -34px;
    }


    .price {
        font-size: 21px !important;
        color: #2e464a !important;
    }

    .add-to-cart {
        background: #2e464a;
        color: #fff;
        border: none;
        text-transform: uppercase;
        margin: 10px 15px 30px 0px;
        padding: 10px 34px;
    }

    .add-to-cart:hover {
        background: #404040;
    }

    .form-group.age-group label {
        min-width: fit-content;
    }
</style>
<?php
    return ob_get_clean();
}