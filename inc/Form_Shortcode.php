<?php

function stoff_form_shortcode_callbadk() {
    ob_start();

    ?>

    <body>

        <!-- main heading -->
        <h1 class="main-heading">STOFF MARKET</h1>

        <!-- loading spinner -->
        <div id="loading-spinner" style="display: none;">
            <img src="<?php echo STOFF_PLUGIN_URI; ?>/assets/images/Spinner.gif" alt="Loading..." />
        </div>

        <!-- Notification container -->
        <div id="notification" class="notification-container">
            <div class="notification-content">
                <span id="notification-message"></span>
                <div class="progress">
                    <div id="notification-progress" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-5 text-center p-0 mt-5 mb-2">

                    <div class="card item-center px-0 pb-0 mb-3">

                        <!-- form start -->
                        <form id="msform" method="POST" enctype="multipart/form-data">

                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"></li>
                                <li id="personal"></li>
                                <li id="payment"></li>
                            </ul>

                            <br>

                            <!-- Step one -->
                            <fieldset class="w-534">

                                <!-- Sub heading -->
                                <h2 class="sub-heading">Your Details</h2>

                                <!-- Step one form fields -->
                                <div class="form-card">
                                    <div id="step-one-fields">

                                        <!-- Website field -->
                                        <div class="website d-grid fs-gic item-center">
                                            <label for="website" class="label-text">Website</label>
                                            <input type="text" class="sf-form-control" name="website" id="website">
                                        </div>

                                        <!-- Already launched field -->
                                        <div class="lanced d-grid fs-gic mt-50">
                                            <label for="launced" class="label-text">Already launched?</label>

                                            <div class="already-launched">
                                                <div>
                                                    <!-- Yes radio -->
                                                    <input type="radio" name="lanced" value="yes" id="yes">
                                                    <label for="yes" class="custom-radio label-text">Yes</label>
                                                </div>

                                                <div>
                                                    <!-- No radio -->
                                                    <input type="radio" name="lanced" value="no" id="no">
                                                    <label for="no" class="custom-radio label-text">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Email field -->
                                        <div class="email d-grid fs-gic mt-50">
                                            <label for="email" class="label-text">Contact E-Mail</label>
                                            <input type="email" class="sf-form-control" name="email" id="email">
                                        </div>

                                    </div>
                                </div>

                                <input type="button" name="next" class="next next-button mt-71" value="Next" />

                            </fieldset>

                            <!-- Step two -->
                            <fieldset class="w-787">

                                <!-- Sub heading -->
                                <h2 class="sub-heading">Fabric Details</h2>

                                <!-- step two fields -->
                                <div id="step-two-fields">

                                    <!-- fabric structure -->
                                    <div class="fabric-section item-center gap-30 d-grid ss-gic mt-50">
                                        <label for="fabric class=" class="label-text">What’s the fabric
                                            <span class="sm-bold">structure?</span></label>

                                        <div class="fabric-structure fgic">
                                            <div>
                                                <!-- Knit radio -->
                                                <input type="radio" name="fabric" value="knit" id="knit">
                                                <label for="knit" class="custom-radio label-text">Knit</label>
                                            </div>

                                            <div>
                                                <!-- Woven radio -->
                                                <input type="radio" name="fabric" value="woven" id="woven">
                                                <label for="woven" class="custom-radio label-text">Woven</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- desired content -->
                                    <div class="desired-content d-grid gap-30 item-center ss-gic mt-50">
                                        <label for="desired-content" class="label-text">Choose your desired
                                            <span class="sm-bold">content</span></label>
                                        <select name="desired-content" id="desired-content">
                                            <option value="">Select...</option>
                                            <option value="linen">Linen</option>
                                            <option value="silk">Silk</option>
                                            <option value="wool">Wool</option>
                                            <option value="tencel">Tencel</option>
                                            <option value="polyester">Polyester</option>
                                            <option value="cotton">Cotton</option>
                                            <option value="rayon">Rayon</option>
                                            <option value="azlon">Azlon</option>
                                            <option value="lyocell">Lyocell</option>
                                            <option value="acetate">Acetate</option>
                                            <option value="triacetate">Triacetate</option>
                                            <option value="acrylic">Acrylic</option>
                                            <option value="anidex">Anidex</option>
                                            <option value="aramid">Aramid</option>
                                            <option value="elastoester">Elastoester</option>
                                            <option value="fluoropolymer">Fluoropolymer</option>
                                            <option value="lastrile">Lastrile</option>
                                            <option value="melamine">Melamine</option>
                                            <option value="modacrylic">Modacrylic</option>
                                            <option value="novoloid">Novoloid</option>
                                            <option value="nylon">Nylon</option>
                                            <option value="olefin">Olefin</option>
                                            <option value="pbi">Polybenzimidazole (PBI)</option>
                                            <option value="rubber">Rubber</option>
                                            <option value="saran">Saran</option>
                                            <option value="spandex">Spandex</option>
                                            <option value="vinyl">Vinyl</option>
                                            <option value="vinyon">Vinyon</option>
                                            <option value="chitosan">Chitosan</option>
                                            <option value="flax">Flax</option>
                                            <option value="hemp">Hemp</option>
                                            <option value="jute">Jute</option>
                                            <option value="ramie">Ramie</option>
                                            <option value="manila">Manila</option>
                                            <option value="sisal">Sisal</option>
                                            <option value="kapok">Kapok</option>
                                            <option value="alpaca">Alpaca</option>
                                            <option value="camel">Camel</option>
                                            <option value="cashmere">Cashmere</option>
                                            <option value="llama">Llama</option>
                                            <option value="mohair">Mohair</option>
                                            <option value="vicuna">Vicuna</option>
                                            <option value="chiffon">Chiffon</option>
                                        </select>

                                    </div>

                                    <!-- Container for selected options -->
                                    <div class="selected-options-parent d-grid ss-gic">
                                        <div class="selected-options-left"></div>
                                        <div id="selected-options"></div>
                                    </div>

                                    <!-- GSM -->
                                    <div class="gsm d-grid item-center gap-30 ss-gic mt-50">
                                        <label for="gsm" class="label-text">What’s the weight
                                            <span class="sm-bold">(GSM)?</span></label>
                                        <input type="number" class="gsm-field" placeholder="000" name="gsm" id="gsm">
                                    </div>

                                    <!-- approx -->
                                    <div class="approx d-grid item-center gap-30 ss-gic mt-50">
                                        <label for="approx" class="label-text">How many <span class="sm-bold">yards</span>
                                            do you
                                            approx.
                                            need?</label>
                                        <input type="number" class="gsm-field" placeholder="0000" name="approx" id="approx">
                                    </div>

                                    <!-- target -->
                                    <div class="target d-grid item-center gap-30 ss-gic mt-50">
                                        <label for="target" class="label-text">What’s the target USD <span
                                                class="sm-bold">cost per
                                                yard?</span></label>
                                        <div class="d-flex item-center gap-11">
                                            <input type="number" class="gsm-field" placeholder="0.00" name="target-from"
                                                id="target">
                                            <p class="to">-to-</p>
                                            <input type="number" class="gsm-field" placeholder="00.00" name="target-to"
                                                id="target">
                                        </div>
                                    </div>

                                    <!-- list the color -->
                                    <div class="list-color d-grid item-center gap-30 ss-gic mt-50">
                                        <label for="list-color" class="label-text">List the <span
                                                class="sm-bold">color(s)</span></label>
                                        <input type="text" class="sf-form-control" name="list-of-color" id="list-color">
                                    </div>

                                    <!-- delivery -->
                                    <div class="delivery d-grid item-center gap-30 ss-gic mt-50">
                                        <label for="delivery" class="label-text">What’s the <span class="sm-bold">target
                                                delivery
                                                date?</span></label>
                                        <div class="d-flex item-center sm-gap-5">
                                            <select name="delivery-day" id="delivery-day">
                                                <option value="">Day</option>
                                            </select>
                                            <select name="delivery-month" id="delivery-month">
                                                <option value="">Month</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>
                                            <select name="delivery-year" id="delivery-year">
                                                <option value="">Year</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ORDERS-PER-YEAR -->
                                    <div class="orders-per-year d-grid item-center gap-30 ss-gic mt-50">
                                        <label for="orders-per-year" class="label-text"># of expected <span
                                                class="sm-bold">orders per
                                                year?</span></label>
                                        <input type="number" class="gsm-field" placeholder="00" name="orders-per-year"
                                            id="orders-per-year">
                                    </div>

                                    <!-- Product field -->
                                    <div class="product d-grid gap-30 item-center ss-gic mt-50">
                                        <label for="product" class="label-text">What’s the <span class="sm-bold">end
                                                product?</span>
                                            e.g.
                                            t-shirt</label>
                                        <input type="text" class="sf-form-control product-field" name="product"
                                            id="product">
                                    </div>

                                </div>

                                <input type="button" name="next" class="next next-button mb-72 mt-71" value="Next" />

                            </fieldset>

                            <!-- Step three -->
                            <fieldset class="w-662">

                                <!-- Sub heading -->
                                <h2 class="sub-heading">Design Details</h2>

                                <div id="step-three-fields">

                                    <!-- UPLOAD -->
                                    <div class="upload-file d-grid gap-76 item-top ts-gic mt-50">
                                        <label for="upload" class="label-text">Upload <span class="sm-bold">fabric
                                                design</span> <br>
                                            *optional</label>
                                        <div class="upload-file-div">
                                            <input type="file" id="fileInput" name="fileInput" />
                                            <label for="fileInput">
                                                <!-- Add your custom icon here -->
                                                <img src="<?php echo STOFF_PLUGIN_URI . '/assets/images/UploadSimple.png' ?>"
                                                    alt="Upload Icon">
                                            </label>
                                        </div>
                                    </div>

                                    <!-- fabric finishes -->
                                    <div class="fabric-finishes d-grid gap-76 item-top ts-gic mt-120">
                                        <label for="fabric-finishes" class="label-text">List the desired <span
                                                class="sm-bold">fabric
                                                finishes</span> <br> *optional </label>
                                        <textarea name="fabric-finishes" id="fabric-finishes"></textarea>
                                    </div>

                                    <!-- Anything else? -->
                                    <div class="anything-else d-grid gap-76 item-top ts-gic mt-120">
                                        <label for="anything-else" class="label-text">Anything else we should know?</label>
                                        <textarea name="anything-else" id="anything-else"></textarea>
                                    </div>

                                </div>

                                <input type="submit" name="next" id="get-bids" class="next-button mb-208 mt-128"
                                    value="Get Bids" />

                            </fieldset>

                        </form>
                        <!-- form end -->

                    </div>
                </div>
            </div>
        </div>

    </body>

    <?php return ob_get_clean();
}

// main form shortcode
add_shortcode( 'stoff_form_shortcode', 'stoff_form_shortcode_callbadk' );


function stoff_thankyou_page() {
    ob_start();
    ?>

    <!-- main heading -->
    <h1 class="main-heading">STOFF MARKET</h1>

    <!-- finish step -->
    <fieldset class="finish-step">

        <!-- Sub heading -->
        <h2 class="sub-heading">Thank you</h2>

        <div id="thank-you-contents">
            <p class="label-text text-center mt-50">Your fabric order has been submitted.</p>
            <p class="label-text text-center mt-50">We will get back to your shortly about <br> the
                status of
                your auction & order.</p>
        </div>

        <!-- Next Button -->
        <button type="button" id="thank-you-button" class="mt-242 mb-282">Create New
            Auction</button>
    </fieldset>

    <?php return ob_get_clean();
}
// thank you page shortcode
add_shortcode( 'stoff_thankyou_page', 'stoff_thankyou_page' );