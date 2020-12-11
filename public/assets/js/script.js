//Animation bouton réseaux sociaux
$(".button-share").click(function(){
    $(".social.twitter").toggleClass("clicked");
    $(".social.facebook").toggleClass("clicked");
    $(".social.instagram").toggleClass("clicked");
})


function createCustomer() {
    let billingEmail = document.querySelector('#email').value;
    return fetch('/create-customer', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: billingEmail,
        }),
    })
        .then((response) => {
            return response.json();
        })
        .then((result) => {
            // result.customer.id is used to map back to the customer object
            return result;
        });
}

// If a fetch error occurs, log it to the console and show it in the UI.
var handleFetchResult = function(result) {
    if (!result.ok) {
        return result.json().then(function(json) {
            if (json.error && json.error.message) {
                throw new Error(result.url + ' ' + result.status + ' ' + json.error.message);
            }
        }).catch(function(err) {
            showErrorMessage(err);
            throw err;
        });
    }
    return result.json();
};



// Handle any errors returned from Checkout
var handleResult = function(result) {
    if (result.error) {
        showErrorMessage(result.error.message);
    }
};

