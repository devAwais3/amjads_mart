<?php

namespace App\Libraries;

class ResendMailer
{
    private string $apiKey;
    private string $from;

    public function __construct()
    {
        $this->apiKey = env('RESEND_API_KEY', '');
        $this->from   = env('RESEND_FROM', 'noreply@amjadsmart.pk');
    }

    public function send(string $to, string $subject, string $htmlBody): bool
    {
        if (empty($this->apiKey) || str_starts_with($this->apiKey, 're_xxx')) {
            log_message('info', "Email (dev skip): To={$to} Subject={$subject}");
            return true;
        }

        $payload = json_encode([
            'from'    => 'Amjad\'s Mart <' . $this->from . '>',
            'to'      => [$to],
            'subject' => $subject,
            'html'    => $htmlBody,
        ]);

        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode === 200 || $httpCode === 201;
    }

    public function sendOrderConfirmation(array $order, string $email, string $name): bool
    {
        $itemsHtml = '';
        foreach ($order['items'] ?? [] as $item) {
            $itemsHtml .= "<tr>
                <td style='padding:8px;border-bottom:1px solid #eee'>{$item['product_name']}</td>
                <td style='padding:8px;border-bottom:1px solid #eee;text-align:center'>{$item['quantity']}</td>
                <td style='padding:8px;border-bottom:1px solid #eee;text-align:right'>Rs.".number_format($item['unit_price'],0)."</td>
                <td style='padding:8px;border-bottom:1px solid #eee;text-align:right'>Rs.".number_format($item['subtotal'],0)."</td>
            </tr>";
        }

        $html = "<!DOCTYPE html><html><body style='font-family:sans-serif;background:#f0fdf4;margin:0;padding:20px'>
        <div style='max-width:600px;margin:auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.1)'>
          <div style='background:#16a34a;padding:30px;text-align:center'>
            <h1 style='color:#fff;margin:0;font-size:24px'>🛒 Amjad's Mart</h1>
            <p style='color:#bbf7d0;margin:8px 0 0'>Order Confirmed!</p>
          </div>
          <div style='padding:30px'>
            <h2 style='color:#0f172a'>Hello {$name}! 👋</h2>
            <p style='color:#64748b'>Your order <strong>#" . str_pad($order['id'], 5, '0', STR_PAD_LEFT) . "</strong> has been placed successfully.</p>
            <table style='width:100%;border-collapse:collapse;margin:20px 0'>
              <thead><tr style='background:#f0fdf4'>
                <th style='padding:10px;text-align:left'>Item</th>
                <th style='padding:10px;text-align:center'>Qty</th>
                <th style='padding:10px;text-align:right'>Price</th>
                <th style='padding:10px;text-align:right'>Total</th>
              </tr></thead>
              <tbody>{$itemsHtml}</tbody>
            </table>
            <div style='background:#f8fafc;border-radius:8px;padding:16px;margin-top:16px'>
              <div style='display:flex;justify-content:space-between;margin-bottom:8px'>
                <span>Subtotal</span><strong>Rs." . number_format($order['subtotal'], 0) . "</strong>
              </div>
              <div style='display:flex;justify-content:space-between;margin-bottom:8px'>
                <span>Delivery</span><strong>" . ($order['delivery_fee'] == 0 ? 'FREE' : 'Rs.' . number_format($order['delivery_fee'], 0)) . "</strong>
              </div>
              " . ($order['discount_amount'] > 0 ? "<div style='display:flex;justify-content:space-between;margin-bottom:8px;color:#16a34a'>
                <span>Discount</span><strong>-Rs." . number_format($order['discount_amount'], 0) . "</strong>
              </div>" : "") . "
              <div style='display:flex;justify-content:space-between;font-size:18px;font-weight:700;color:#16a34a;border-top:2px solid #e2e8f0;padding-top:8px'>
                <span>Total</span><span>Rs." . number_format($order['total'], 0) . "</span>
              </div>
            </div>
            <div style='margin-top:24px;padding:16px;background:#fff7ed;border-radius:8px;border-left:4px solid #fbbf24'>
              <strong>📍 Delivery Address</strong><br>
              {$order['delivery_name']}<br>
              {$order['delivery_address']}, {$order['delivery_city']}
            </div>
            <p style='color:#64748b;margin-top:24px'>Payment: <strong>" . strtoupper($order['payment_method']) . "</strong></p>
          </div>
          <div style='background:#0f172a;padding:20px;text-align:center;color:#94a3b8'>
            <p style='margin:0'>Amjad's Mart · Mardan, KPK Pakistan</p>
            <p style='margin:8px 0 0'>📞 0300-1234567 · Fresh. Fast. Local.</p>
          </div>
        </div></body></html>";

        return $this->send($email, 'Order Confirmed #' . str_pad($order['id'], 5, '0', STR_PAD_LEFT) . ' — Amjad\'s Mart', $html);
    }

    public function sendWelcomeNewsletter(string $email): bool
    {
        $html = "<!DOCTYPE html><html><body style='font-family:sans-serif;background:#f0fdf4;margin:0;padding:20px'>
        <div style='max-width:500px;margin:auto;background:#fff;border-radius:16px;overflow:hidden'>
          <div style='background:linear-gradient(135deg,#16a34a,#15803d);padding:40px;text-align:center'>
            <h1 style='color:#fff;font-size:28px;margin:0'>🛒 Amjad's Mart</h1>
            <p style='color:#bbf7d0'>Fresh. Fast. Local.</p>
          </div>
          <div style='padding:30px;text-align:center'>
            <h2 style='color:#0f172a'>Welcome to the Family! 🎉</h2>
            <p style='color:#64748b'>You're now subscribed to Amjad's Mart newsletter. Get exclusive deals, new arrivals, and special offers delivered to your inbox.</p>
            <a href='http://amjadsmart.pk' style='display:inline-block;background:#16a34a;color:#fff;padding:14px 32px;border-radius:50px;text-decoration:none;font-weight:700;margin-top:16px'>Shop Now →</a>
          </div>
          <div style='background:#0f172a;padding:16px;text-align:center;color:#94a3b8;font-size:13px'>
            <p style='margin:0'>Mardan, KPK Pakistan · Unsubscribe anytime</p>
          </div>
        </div></body></html>";

        return $this->send($email, 'Welcome to Amjad\'s Mart Newsletter! 🎉', $html);
    }

    public function sendContactNotification(array $contact): bool
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@amjadsmart.pk');
        $html = "<div style='font-family:sans-serif;padding:20px'>
          <h2>New Contact Message</h2>
          <p><strong>From:</strong> {$contact['name']} ({$contact['email']})</p>
          <p><strong>Subject:</strong> {$contact['subject']}</p>
          <div style='background:#f8fafc;padding:16px;border-radius:8px;margin-top:12px'>
            <p>{$contact['message']}</p>
          </div>
        </div>";

        return $this->send($adminEmail, 'New Contact: ' . $contact['subject'], $html);
    }
}