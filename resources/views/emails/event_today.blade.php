<div style="font-family: Arial, sans-serif; background-color:#f5f5f5; padding:20px;">
    <div style="max-width:600px; margin:0 auto; background-color:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden;">
        <!-- Header -->
        <div style="background-color:#c0392b; color:white; padding:15px; text-align:center; font-size:18px; font-weight:bold;">
            Event Today!
        </div>

        <!-- Body -->
        <div style="padding:20px; color:#333333; font-size:16px; line-height:1.5;">
            <p>Hello,</p>
            <p>Today is your event <strong>{{ $event->title }}</strong>.</p>

            <div style="background-color:#f8d7da; color:#721c24; padding:15px; border-radius:6px; margin:15px 0;">
                <p><strong>Venue:</strong> {{ $event->venue }}</p>
                <p><strong>Time:</strong> {{ $event->time }}</p>
            </div>

            <p>Make sure you are on time and prepared!</p>
        </div>

        <!-- Footer -->
        <div style="background-color:#f5f5f5; color:#888888; padding:10px; text-align:center; font-size:12px;">
            &copy; {{ date('Y') }} Troupesync. All rights reserved.
        </div>
    </div>
</div>
