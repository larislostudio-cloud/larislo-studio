<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Kredit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-xl shadow-lg text-center max-w-md">
        <h1 class="text-xl font-bold text-gray-800 mb-2">Memproses Pembayaran</h1>
        <p class="text-gray-500 mb-6">Anda akan diarahkan ke halaman pembayaran Midtrans...</p>

        <div id="loading-spinner" class="animate-spin rounded-full h-12 w-12 border-b-2 border-sky-600 mx-auto mb-4"></div>

        <p class="text-xs text-gray-400">Paket: <strong>{{ $package->name }}</strong> ({{ $package->total_credits }} Kredit)</p>
        <p class="text-lg font-bold text-sky-600">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
    </div>

    <script>
        // Ganti 'snapToken' dengan variabel yang dikirim dari controller
        var snapToken = "{{ $snapToken }}";

        // Langsung buka popup Snap ketika halaman dibuka
        window.onload = function() {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    // Jika pembayaran sukses
                    console.log(result);
                    alert("Pembayaran Berhasil! Kredit Anda akan bertambah setelah notifikasi server diproses.");
                    window.location.href = "/billing"; // Redirect ke halaman billing
                },
                onPending: function(result) {
                    // Jika pembayaran pending (misal bank transfer)
                    console.log(result);
                    alert("Menunggu pembayaran Anda.");
                    window.location.href = "/billing";
                },
                onError: function(result) {
                    // Jika error
                    console.log(result);
                    alert("Terjadi kesalahan pada pembayaran.");
                    window.location.href = "/billing";
                },
                onClose: function() {
                    // Jika user menutup popup tanpa menyelesaikan
                    alert('Anda menutup popup pembayaran.');
                    window.location.href = "/billing";
                }
            });
        };
    </script>
</body>
</html>
