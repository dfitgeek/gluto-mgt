<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'System Alert: Profile Provisioned' }}</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #F8FAFC; font-family: 'Segoe UI', Helvetica, Arial, sans-serif; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"
        style="background-color: #F8FAFC; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" max-width="600px"
                    style="max-width: 600px; width: 100%; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">

                    <tr>
                        <td style="background-color: #0F172A; padding: 24px 32px; text-align: left;">
                            <span
                                style="font-size: 18px; font-weight: 800; color: #FFFFFF; letter-spacing: -0.5px; text-decoration: none;">
                                Gluto International <span style="color: #94A3B8; font-weight: 400;">Procurement
                                    Network</span>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 32px;">
                            <h2
                                style="margin: 0 0 12px 0; font-size: 20px; font-weight: 700; color: #0F172A; tracking: -0.5px;">
                                {{ $title }}
                            </h2>

                            <p
                                style="margin: 0 0 24px 0; font-size: 13px; font-weight: 500; line-height: 1.6; color: #475569;">
                                {{ $body }}
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="background-color: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 16px; margin: 24px 0; padding: 16px;">
                                <tr>
                                    <td
                                        style="padding: 4px 0; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; width: 40%;">
                                        Profile Email:</td>
                                    <td
                                        style="padding: 4px 0; font-size: 12px; font-weight: 700; color: #0F172A; font-family: monospace;">
                                        {{ $email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 4px 0; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; width: 40%;">
                                        Access Node:</td>
                                    <td
                                        style="padding: 4px 0; font-size: 12px; font-weight: 700; color: #0F172A; font-family: monospace;">
                                        {{ $role }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 4px 0; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; width: 40%;">
                                        Pipeline Status:</td>
                                    <td
                                        style="padding: 4px 0; font-size: 12px; font-weight: 700; color: #0F172A; font-family: monospace;">
                                        {{ $status }}
                                    </td>
                                </tr>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="margin: 28px 0 12px 0;">
                                <tr>
                                    <td align="left">
                                        <a href="{{ $link }}" target="_blank"
                                            style="display: inline-block; background-color: #0F172A; color: #FFFFFF; font-size: 12px; font-weight: 700; text-decoration: none; padding: 12px 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(15,23,42,0.15);">
                                            {{ $linkText }}
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background-color: #F1F5F9; padding: 20px 32px; border-top: 1px solid #E2E8F0; text-align: left; font-size: 11px; font-weight: 500; color: #64748B; line-height: 1.5;">
                            <span style="display: block; font-weight: 700; color: #475569; margin-bottom: 2px;">Security
                                Notice Disclaimer:</span>
                            This message is an automated operation alert tracking secure transaction pipeline
                            parameters. Do not forward or distribute internal authentication dashboard tokens outside
                            your verified business infrastructure lines.
                            <div style="margin-top: 12px; font-family: monospace; color: #94A3B8; font-size: 10px;">
                                &copy; 2026 Gluto International Procurement Architecture.</div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
