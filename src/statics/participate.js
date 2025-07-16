/**
 * Updates the displayed price based on the number of entries and payment method
 * @param {string} language - The language code ('en' for English, 'es' for Spanish)
 */
function updatePrice(language) {
    const countInput = document.getElementById('count');
    const count = parseInt(countInput.value) || 0;
    const paymentMethod = document.getElementById('payment_method').value;
    const calculatedPriceElement = document.getElementById('calculatedPrice');

    if (paymentMethod === 'bitcoin') {
        // Bitcoin price: 0.000020 BTC per participation
        const btcBase = count * 0.000020;
        const btcDiscount = Math.floor(count / 5) * 0.000010; // 0.000010 BTC discount (equivalent to 1 EUR)
        const btcTotal = btcBase - btcDiscount;
        const formattedBtcTotal = btcTotal.toFixed(6);
        
        if (language === 'es') {
            calculatedPriceElement.textContent = `Precio total: ${formattedBtcTotal.replace('.', ',')} BTC`;
        } else {
            calculatedPriceElement.textContent = `Total price: ${formattedBtcTotal} BTC`;
        }
    } else {
        // Euro price: 2 EUR per participation
        const base = count * 2;
        const discount = Math.floor(count / 5);
        const total = base - discount;
        const formattedTotal = total.toFixed(2);
        
        if (language === 'es') {
            calculatedPriceElement.textContent = `Precio total: ${formattedTotal.replace('.', ',')} €`;
        } else {
            calculatedPriceElement.textContent = `Total price: ${formattedTotal} €`;
        }
    }
}

/**
 * Updates the payment method fields based on the selected payment method
 * @param {string} language - The language code ('en' for English, 'es' for Spanish)
 */
function updatePaymentMethod(language) {
    const paymentMethod = document.getElementById('payment_method').value;
    const transactionLabel = document.getElementById('transaction_label');
    const transactionInput = document.getElementById('transaction');

    if (paymentMethod === 'paypal') {
        transactionInput.placeholder = 'H340GBTIO4HDE5TK5';
        if (language === 'es') {
            transactionLabel.textContent = 'ID de transacción de PayPal:';
        } else {
            transactionLabel.textContent = 'PayPal Transaction ID:';
        }
    } else if (paymentMethod === 'bizum') {
        transactionInput.placeholder = 'IVAN M. P.';
        if (language === 'es') {
            transactionLabel.textContent = 'Nombre como aparece en Bizum:';
        } else {
            transactionLabel.textContent = 'Name as written in Bizum:';
        }
    } else if (paymentMethod === 'bitcoin') {
        transactionInput.placeholder = '3a1b2c…';
        if (language === 'es') {
            transactionLabel.textContent = 'Hash de transacción de Bitcoin:';
        } else {
            transactionLabel.textContent = 'Bitcoin Transaction Hash:';
        }
    }

    updatePrice(language);
}

/**
 * Initialize the form when the page loads
 * @param {string} language - The language code ('en' for English, 'es' for Spanish)
 */
function initializeForm(language) {
    // Set the initial payment method display
    updatePaymentMethod(language);
    
    // Set up event listeners
    document.getElementById('count').addEventListener('input', function() {
        updatePrice(language);
    });
    
    document.getElementById('payment_method').addEventListener('change', function() {
        updatePaymentMethod(language);
    });
}

// Set up the window.onload event handler
window.onload = function() {
    // Detect language from the html tag
    const htmlTag = document.documentElement.lang;
    const language = htmlTag === 'es' ? 'es' : 'en';
    
    // Initialize the form with the detected language
    initializeForm(language);
};