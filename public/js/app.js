const login_status_container = document.getElementById(
  "login-status-container"
);

const register_status_container = document.getElementById(
  "register-status-container"
);

const set_item_entities_request_status = document.getElementById('set-item-entities-request-status');

const request_check_item_price_btn = document.getElementById('request-check-item-price-btn');

const track_price_request_status = document.getElementById('track-price-request-status');

document.addEventListener("DOMContentLoaded", () => {
  login_to_system();
  register_onto_system();
  set_product_entity();
  checkPrice();
  generate_track_price_report_if_exists();
});

/*****
 * success/error handler
 * params passed:
 *      ~status - error, success or warning
 *      ~context - status context to be shown to user!
 */
function status_display(status, context) {
  let alert_element = "";
  if (status.includes("error")) {
    alert_element = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>${context}</strong>
                        </div>`;
  } else if (status.includes("success")) {
    alert_element = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>${context}</strong>
                        </div>`;
  }

  return alert_element;
}

// Send Requests //
function login_to_system() { 
    const login_submit_btn = document.getElementById("login-submit-btn");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
        

    if (document.body.contains(login_submit_btn)) {
        login_submit_btn.addEventListener("click", (event) => {
        event.preventDefault();
        
        if (email.value.length == 0 || password.value.length == 0) {
          login_status_container.innerHTML = status_display(
            "error",
            "All fields must field to continue!"
          );
        } else {
          console.log(email.value);
          console.log(password.value);

          let method = "POST";
          let action = "/login";
          let urlParams = `email=${email.value}&password=${password.value}`;

          server_request(method, action, urlParams);
        }
        });
    }
}

function register_onto_system() {
  const username = document.getElementById("username");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const cpassword = document.getElementById("cpassword");
  const register_submit_btn = document.getElementById("register-submit-btn");

  if (document.body.contains(register_submit_btn)) {
    register_submit_btn.addEventListener("click", (event) => {
      event.preventDefault();

      if (
        username.value.length == 0 ||
        email.value.length == 0 ||
        password.value.length == 0 ||
        cpassword.value.length == 0
      ) {
        register_status_container.innerHTML = status_display(
          "error",
          "All fields must field to continue!"
        );
      } else {
        console.log(username.value);
        console.log(email.value);
        console.log(password.value);

        let method = "POST";
        let action = "/register";
        let urlParams = `username=${username.value}&email=${email.value}&password=${password.value}&cpassword=${cpassword.value}`;

        server_request(method, action, urlParams);
      }
    });
  }
}

function set_product_entity() {
  const valid_item_link = document.getElementById('valid-item-link');
  const product_current_price = document.getElementById('product-current-price');
  const product_desired_price = document.getElementById('product-desired-price');
  const set_item_btn = document.getElementById('set-item');

  if (document.body.contains(set_item_btn)) {
    set_item_btn.addEventListener("click", (event) => {
      event.preventDefault();

      if (
        valid_item_link.value.length == 0 ||
        product_current_price.value.length == 0 ||
        product_desired_price.value.length == 0
      ) {
        set_item_entities_request_status.innerHTML = status_display(
          "error",
          "Kindly, All fields must be filled!"
        );
      } else {
        set_item_btn.innerHTML = `<div class="spinner-border"></div>`;
        let method = "POST";
        let action = "/set-product-entity";
        let urlParams = `product_link=${valid_item_link.value}&product_current_price=${product_current_price.value}&product_desired_price=${product_desired_price.value}`;

        server_request(method, action, urlParams);
      }
    });
  }
}

function checkPrice() {
  if (document.body.contains(request_check_item_price_btn)) {
    request_check_item_price_btn.addEventListener('click', (event) => {
      event.preventDefault();
       request_check_item_price_btn.innerHTML = `<div class="spinner-border"></div>`;
       let method = "POST";
       let action = "/track_price";
       let urlParams = ``;

       server_request(method, action, urlParams);
    });
  }
}

function generate_track_price_report_if_exists() {
  const generate_track_price_report_btn = document.getElementById(
    "generate-track-price-report-btn"
  );
  const start_date = document.getElementById('start_date');
  const end_date = document.getElementById('end_date');

   const track_price_report_tbody = document.getElementById(
     "track-price-report-tbody"
   );

  generate_track_price_report_btn.addEventListener('click', (event) => {
    event.preventDefault();
    
    track_price_report_tbody.innerHTML = `<tr><td style="color: red;text-align: center;" colspan="6"><div style="font-size: 15rem;" class="spinner-border"></div></tr></td>`;

    let method = "GET";
    let action = `/fetch_report?start_date=${start_date.value}&end_date=${end_date.value}`;
    let urlParams = ``;

    server_request(method, action, urlParams);
  });
}
// End Send Requests //

// Server Response Handlers //
function handle_login_request(response) {
  let login_response = response;
  console.log(login_response);

  if (login_response.includes("login success!")) {
    window.location.href = "/dashboard";
  } else if (
    login_response.includes("sql error") ||
    login_response.includes("Oops! an unexpected server error")
  ) {
    login_status_container.innerHTML = status_display(
      "error",
      "Kindly try again after sometime. Server experienced a little glitch!"
    );
  } else if (login_response.includes("email and password might be wrong!")) {
    login_status_container.innerHTML = status_display(
      "error",
      "Kindly check your username and password and try again!"
    );
  } else {
    window.location.href =
      "/login?error=Oops, an error occured. kindly check your username and password!";
    return;
  }
}

function handle_register_request(response) {
  let register_response = response;

  console.log(register_response);

  if (register_response.includes("register success!")) {
    window.location.href = "/?registration=Registration success. Proceed to login!";
  } else if (
    register_response.includes("sql error") ||
    register_response.includes("Oops! an unexpected server error")
  ) {
    register_status_container.innerHTML = status_display(
      "error",
      "Kindly try again after sometime. Server experienced a little glitch!"
    );
  } else if (register_response.includes("Email already exists")) {
    register_status_container.innerHTML = status_display(
      "error",
      "Email is already in use. try using a different email!"
    );
  } else {
    window.location.href = "/register?error=Oops, an error occured. kindly check your username, email and password and try again!";
    return;
  }
}

function handle_set_item_entity_request(response) {
  console.log(response); 

  if (response.includes("item entity save success!")) {
    set_item_entities_request_status.innerHTML = status_display(
      "success",
      "Product Entity Saved Successfully. You can track your item price change later!"
    );
  } else if (response.includes("item entity save failed!")) {
    set_item_entities_request_status.innerHTML = status_display(
      "error",
      "Oops, An unexpected error occurred!"
    );
  } else if (response.includes("item entity already exists")) {
    set_item_entities_request_status.innerHTML = status_display(
      "error",
      "Product Entity Already Exists!"
    );
  } else if (response.includes("All fields should not be null!")) {
    set_item_entities_request_status.innerHTML = status_display(
      "error",
      "Kindly, All fields must be filled!"
    );
  }

  const set_item_btn = document.getElementById("set-item");

  set_item_btn.innerHTML = 'Set';
}

function handle_track_product_price_request(response) {
  console.log(response);

  const request_check_item_price_btn = document.getElementById(
    "request-check-item-price-btn"
  );

  request_check_item_price_btn.innerHTML = "Check Tracking Status";

  if (response.includes("cURL is not installed. Install and try again.")) {
    track_price_request_status.innerHTML = status_display(
      "success",
      "Oops, An unexpected error happened!"
    );
  } else if (
    response.includes("Seems no available item set!") ||
    response.includes("unable to parse the URL")
  ) {
    track_price_request_status.innerHTML = status_display(
      "error",
      "Oops, An unexpected error occurred. Please try again later!"
    );
  } else if (response.includes("sent mail success")) {
    track_price_request_status.innerHTML = status_display(
      "error",
      "Notification Status of your product sent to your email successfully. Kindly check on your email."
    );
  } else {
    track_price_request_status.innerHTML = status_display(
      "error",
      "Oops, An unexpected error happened. Please try again later!"
    );
  }
}


function handle_report_fetch_request(response) {
  // console.log(response);

  const track_price_report_tbody = document.getElementById(
    "track-price-report-tbody"
  );
  let result = "";
  
  if (response.includes("item_target_price")) {
    const response_object = JSON.parse(response);
    console.log(response_object);

    response_object.forEach((response) => {
      console.log(response);

      result += `<tr>
                  <td style="text-align: left;">${response.item_link}</td>
                  <td style="text-align: left;">${(response.item_price == 'null') ? (0).toFixed(2) : Number(response.item_price).toFixed(2)}</td>
                  <td style="text-align: left;">${
                    (response.item_target_price == 'null') ? (0).toFixed(2) : Number(response.item_target_price).toFixed(2)
                  }</td>
                  <td style="text-align: left;">${
                    response.status == 0
                      ? "Price Normal"
                      : response.status == 1
                      ? "Price Down from Normal"
                      : response.status == 2
                      ? "Price Up from Normal"
                      : ""
                  }</td>
                  <td style="text-align: left;">${response.created_at}</td>
                  <td style="text-align: left;">${response.updated_at}</td>
                </tr>`;
    });
  } else if (response.includes("date fields cannot be null!")) {
    result = `<tr>
                <td style="color: red;text-align: center;" colspan="6">Please, Fill in dates to have a specified report!</td>
              </tr>`;
  } else if (response.includes("report is null")) {
    result = `<tr>
                <td style="color: red;text-align: center;" colspan="6">No available report. If report is available, will appear here!</td>
              </tr>`;
  } else {
    result = `<tr>
                <td style="color: red;text-align: center;" colspan="6">No available report. If report is available, will appear here!</td>
              </tr>`;
  }
 
  track_price_report_tbody.innerHTML = result;
}

function display_toast(status, time, message) {
  toastr.options.newestOnTop = true;
  toastr.options.timeOut = time;
  toastr.options.extendedTimeOut = 0;
  toastr.options.progressBar = true;
  toastr.options.rtl = false;
  toastr.options.closeButton = true;
  toastr.options.closeMethod = "fadeOut";
  toastr.options.closeDuration = 300;
  toastr.options.closeEasing = "swing";
  toastr.options.preventDuplicates = true;

  if (status == "success") {
    toastr.success(message);
  } else if (status == "warning") {
    toastr.warning(message);
  } else if (status == "error") {
    toastr.error(message);
  }
}

// End of Server Response Handlers //

/*******
 * SERVER FUNCTION
 * @params
 *    ~ @method
 *    ~ @action
 *    ~ @urlParams
 */
function server_request(method, action, urlParams='') {
  let xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.status == 500) {
      if (this.responseURL.includes("/get_har_data")) {
        alert("Oops an Unexpected Error!")
      }
    } else if (this.readyState == 4 && this.status == 200) {
      if (this.responseURL.includes("/login")) {
        handle_login_request(this.responseText);
      } else if (this.responseURL.includes("/register")) {
        handle_register_request(this.responseText);
      } else if (this.responseURL.includes("/set-product-entity")) {
        handle_set_item_entity_request(this.responseText);
      } else if (this.responseURL.includes("/track_price")) {
        handle_track_product_price_request(this.responseText);
      } else if (this.responseURL.includes("/fetch_report")) {
        handle_report_fetch_request(this.responseText);
      } else {
        console.log(this.responseText);
      }
    }
  };
  xhttp.open(method, action, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.setRequestHeader("Accept-Language", "*");
  xhttp.send(urlParams);
}


