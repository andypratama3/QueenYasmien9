<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pengiriman</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
            background: #f9f9f9;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #333;
        }
        .info, .products {
            margin-bottom: 20px;
        }
        .info table, .products table {
            width: 100%;
            border-collapse: collapse;
        }
        .info td, .products th, .products td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .products th {
            background: #f5f5f5;
            text-align: left;
        }
        .products td {
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
        .qr-code {
            text-align: center;
            margin-top: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #qrcode {
            display: inline-block;
        }

        .qr-code {
            text-align: center;
            margin-top: 15px;
        }
        .qr-code img {
            max-width: 100px;
        }

    @media print {
        @page {
        size: A4;
        margin: 0;
    }
        .container {
            max-width: 100%;
            padding: 0;
            box-shadow: none;
        }
    }

    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{ asset('assets/images/logo-small.png') }}" alt="Logo Perusahaan">
        <h2>Resi Pengiriman</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Nama:</strong></td>
                <td>{{ $pemesanan->user->name }}</td>
            </tr>
            <tr>
                <td><strong>Order ID:</strong></td>
                <td>{{ $pemesanan->order_id }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Pemesanan:</strong></td>
                <td>{{ \Carbon\Carbon::parse($pemesanan->created_at)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Alamat Pengiriman:</strong></td>
                <td>{{ $pemesanan->alamat }}</td>
            </tr>
            <tr>
                <td><strong>Pengiriman:</strong></td>
                <td>{{ $pemesanan->pengiriman }}</td>
            </tr>
            <tr>
                <td><strong>Total Pembayaran:</strong></td>
                <td><strong>Rp {{ number_format($pemesanan->gross_amount, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="products">
        <h3>Daftar Produk</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Paket Reseller</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemesanan->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->product_reseller->first()->name ?? '-' }}</td>
                    <td>{{ $product->pivot->qty ?? 1 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="qr-code">
        <div id="qrcode" style="justify-content: center;"></div>
        <h4>Scan untuk melihat detail pesanan</h4>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja di toko kami.</p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        let qrCodeText = @json($qrCode);

        new QRCode(document.getElementById("qrcode"), {
            text: qrCodeText,
            width: 128,
            height: 128
        });
    });

    window.print();
</script>

</body>
</html>
