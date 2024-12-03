<?php

add_shortcode('checkout_form', 'custom_shortcode_function');
function custom_shortcode_function()
{
    // get product id
    $productId = get_the_ID();
    $product = wc_get_product($productId);
    $meeting_points = get_field('meeting_points', $productId);
    ob_start();
    ?>
    <div class="checkout-form">
        <form method="post" action="" id="checkout_form">
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group mt-3">
                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name (if applicable)" required>
            </div>
            <div class="form-group mt-3">
                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number*" required>
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
                <select class="form-select mt-2" aria-label="Default select example">
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

            <div class="form-group age-group mt-3 mb-5">
                <label for="age">Age</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" id="minus" onclick="decreaseAge()">-</button>
                    </div>
                    <input type="text" class="form-control" id="age" name="age" placeholder="Age" value="0" required>
                    <div class="input-group-append">
                        <button type="button" id="plus" onclick="increaseAge()">+</button>
                    </div>
                </div>
            </div>

            <hr/>
            <h3 class="document-title">Upload verification Documents</h3>
            <div class="row">
                <div class="col-4">
                    <div class="form-group mt-3">
                        <label for="driver_license" class="form-label">Diver's License <span class="text-danger">*certified divers only</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <label class="custom-file-label" for="diver_license">Choose file</label>
                                <input type="file" class="custom-file-input" id="diver_license" name="diver_license" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group mt-3">
                        <label for="driver_license" class="form-label">Driver's Passport <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <label class="custom-file-label" for="driver_passport">Choose file</label>
                                <input type="file" class="custom-file-input" id="driver_passport" name="driver_passport" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="add-to-cart">Add to Cart</button>
                <span class="price">
                    <?php  echo wc_price($product->get_price()); ?>
                </span>
                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
            </div>
            <hr/>

        </form>
    </div>
    
  
    <script>
            function increaseAge() {
                var age = document.getElementById('age').value;
                document.getElementById('age').value = parseInt(age) + 1;
            }

            function decreaseAge() {
                var age = document.getElementById('age').value;
                if (age > 0) {
                    document.getElementById('age').value = parseInt(age) - 1;
                }
            }
        </script>

        <style>
            
            .form-select,.form-control {
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
                width: 35px !important;
                flex: inherit;
                font-size: 26px;
                padding: 0px 10px !important;
            }


            .input-group-append button, .input-group-prepend button {
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

            .input-group-append button:hover, .input-group-prepend button:hover {
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
        </style>
    <?php
    return ob_get_clean();
}