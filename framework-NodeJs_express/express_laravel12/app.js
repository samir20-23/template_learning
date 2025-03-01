import express from 'express';
import Stripe from 'stripe';

const app = express();
const stripe = new Stripe('your-stripe-secret-key');  // Use your real Stripe key

app.post('/api/charge', async (req, res) => {
    const { token, amount } = req.body; // Get payment data from frontend

    try {
        // Process the payment via Stripe API
        const charge = await stripe.charges.create({
            amount: amount * 100, // Amount in cents
            currency: 'usd',
            source: token.id,     // Token received from frontend
            description: 'E-commerce Order Payment',
        });

        res.status(200).json({ success: true, charge });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

app.listen(3001, () => {
    console.log('Stripe payment server running on http://localhost:3001');
});
