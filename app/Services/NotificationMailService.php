<?php

namespace App\Services;

use App\Models\AdminOrder;
use App\Models\BuyerOrder;
use App\Models\AdminOrderTracker;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificationMailService
{
    /**
     * Send a unified, beautifully formatted high-contrast Gluto International email.
     */
    protected static function sendMailable(string $recipientEmail, string $subject, string $title, string $message, ?string $ctaUrl = null, ?string $ctaText = null, array $metaSpecs = [])
    {
        Mail::send('emails.gluto-notification', [
            'title'       => $title,
            'bodyContent' => $message,
            'ctaUrl'      => $ctaUrl,
            'ctaText'     => $ctaText,
            'metaSpecs'   => $metaSpecs
        ], function ($mail) use ($recipientEmail, $subject) {
            $mail->to($recipientEmail)->subject("Gluto International | {$subject}");
        });
    }


    /**
     * Send a welcome email to a newly registered Buyer
     */
    public static function notifyNewBuyerRegistration($buyer)
    {
        $subject = 'System Alert: Buyer Profile Provisioned';

        $data = [
            'title' => 'Registration Alert: New Buyer Profile',
            'body' => 'A secure buyer profile session has been initialized and provisioned onto the active procurement pipeline. You may now begin dispatching RFQs to the administrative network.',
            'email' => $buyer->rep_email, // Or whatever your column name is
            'role' => 'Buyer',
            'status' => 'Unverfied Buyer',
            'link' => route('buyer.login'),
            'linkText' => 'Access Dashboard'
        ];

        Mail::send('emails.profile-registration', $data, function ($message) use ($buyer, $subject) {
            $message->to($buyer->rep_email)->subject($subject);
        });
    }

    /**
     * Send a welcome email to a newly registered Supplier
     */
    public static function notifyNewSupplierRegistration($supplier)
    {
        $subject = 'System Alert: Supplier Profile Provisioned';

        $data = [
            'title' => 'Registration Alert: New Supplier Profile',
            'body' => 'A secure supplier profile session has been registered on the network. The account is currently locked pending administrative verification and compliance checks.',
            'email' => $supplier->rep_email,
            'role' => 'Supplier',
            'status' => 'Pending Verification',
            'link' => route('supplier.login'),
            'linkText' => 'Access Supplier Dashboard'
        ];

        Mail::send('emails.profile-registration', $data, function ($message) use ($supplier, $subject) {
            $message->to($supplier->rep_email)->subject($subject);
        });
    }

    /**
     * Helper: Dispatch a notification copy directly to all back-office operational administrators.
     */
    protected static function emailAllActiveAdmins(string $subject, string $title, string $message, ?string $ctaUrl = null, ?string $ctaText = null, array $metaSpecs = [])
    {
        $admins = User::whereIn('usertype', ['superadmin', 'operationsadmin'])->pluck('email');

        foreach ($admins as $adminEmail) {
            self::sendMailable($adminEmail, $subject, $title, $message, $ctaUrl, $ctaText, $metaSpecs);
        }
    }

    // Done =========================================================================
    // BRANCH A: ADMIN SYSTEM NOTIFICATION TRIGGERS (INBOUND ALERTS TO ADMIN)
    // =========================================================================

    public static function notifyAdminOfBuyerQuote(array $quoteData, string $buyerEmail)
    {
        self::emailAllActiveAdmins(
            "New Buyer Sourcing Request Started",
            "A buyer has initiated a quotation order",
            "A fresh wholesale sourcing quote request has been uploaded to the dashboard lines. Please inspect specifications quote details and update accordingly.",
            url('/admin/recent-orders'),
            "Open Operations Dashboard",
            ['Buyer Contact' => $buyerEmail, 'Quote Order Name' => $quoteData['product_names'] ?? 'Bulk Goods']
        );
    }

    /** Done
     * DYNAMIC FIX: Accepts the dynamic subject string context selection and reply content typed by the Buyer.
    */

    public static function notifyAdminOfBuyerConversation(BuyerOrder $order, string $customSubject, string $messageContent)
    {
        self::emailAllActiveAdmins(
            "Buyer Thread Update: {$customSubject}",
            "Message received on Order Reference #{$order->order_ref_number}",
            "A buyer profile session has appended an update note to their active negotiation thread:\n\n\"{$messageContent}\"",
            url("/admin/buyer-quotes/{$order->id}/tracker"),
            "View Tracker Thread",
            ['PO Number' => $order->order_ref_number, 'Topic Context' => $customSubject, 'Total Value' => "{$order->quotation_currency} " . number_format($order->grand_total_price, 2)]
        );
    }

    public static function notifyAdminOfInvoiceUpload(AdminOrder $order, string $supplierName)
    {
        self::emailAllActiveAdmins(
            "Supplier Invoice Dispatched",
            "Proforma Billing Statement Uploaded",
            "The vendor enterprise [{$supplierName}] has uploaded an itemized commercial proforma invoice directly against the order sheet tracking lines index. Review it to clear financial wire remittances.",
            url("/admin/suppliers/{$order->id}/tracker"),
            "Inspect Billing Invoice",
            ['Fulfilling Supplier' => $supplierName, 'PO Voucher Reference' => $order->purchase_order_number]
        );
    }

    /** Done
     * DYNAMIC FIX: Accepts the dynamic subject string context selection and reply content typed by the Supplier.
     */
    public static function notifyAdminOfSupplierConversation(AdminOrder $order, string $customSubject, string $messageContent)
    {
        self::emailAllActiveAdmins(
            "Supplier Thread Update: {$customSubject}",
            "Vendor Message Update Detected",
            "A wholesale manufacturing partner [{$order->supplier->company_name}] has submitted an operational response to the discussion tracker workspace:\n\n\"{$messageContent}\"",
            url("/admin/suppliers/{$order->id}/tracker"),
            "Open Admin Tracker Desk",
            ['PO Reference' => $order->purchase_order_number, 'Topic Scope' => $customSubject]
        );
    }

    // Done =========================================================================
    // BRANCH B: BUYER SYSTEM NOTIFICATION TRIGGERS (OUTBOUND ALERTS TO BUYER)
    // =========================================================================

    public static function notifyBuyerOfQuoteReceipt(string $buyerEmail, array $quoteDetails)
    {
        self::sendMailable(
            $buyerEmail,
            "Sourcing Request Received Successfully",
            "Sourcing Registry Acknowledgment",
            "Your cross-border bulk sourcing quote request has been securely registered on our Gluto International database indices. Back-office logistics operations staff are auditing container freight bounds to configure your pricing sheets.",
            url('/buyer/dashboard'),
            "Go to Buyer Console",
            ['Commodity Matrix' => $quoteDetails['product_names'] ?? 'Bulk Sourcing Lines']
        );
    }

    /** Done
     * DYNAMIC FIX: Relays the exact administrative auditing response content and subject context down to the Buyer.
     */
    public static function notifyBuyerOfQuoteTrackerUpdate(string $buyerEmail, BuyerOrder $order, string $adminSubject, string $adminMessageContent)
    {
        self::sendMailable(
            $buyerEmail,
            "Ecosystem Workspace Update: {$adminSubject}",
            "You have a response from us regarding your quote with {$order->order_ref_number}",
            "An admin manager has responded to your recently submitted quote[{$adminSubject}]:\n\n\"{$adminMessageContent}\"",
            url('/buyer/orders/' . $order->id . '/negotiation-tracker'),
            "Open Tracker Thread",
            ['Order Reference' => $order->order_ref_number, 'Subject' => $adminSubject, 'Order Progress' => $order->order_progress]
        );
    }

    public static function notifyBuyerOfReceiptUploadConfirmation(string $buyerEmail, string $orderRef)
    {
        self::sendMailable(
            $buyerEmail,
            "Wire Remittance Slip Received",
            "Payment Document Vault Logged",
            "Your uploaded bank remitted wire transfer receipt slip has been securely saved to our escrow verification ledger indexes. The Gluto International accounting clearing team is auditing the settlement payload loop.",
            url('/buyer/dashboard'),
            "Check Settlement History",
            ['Order Reference Hash' => $orderRef]
        );
    }

    // =========================================================================
    // BRANCH C: SUPPLIER SYSTEM NOTIFICATION TRIGGERS (OUTBOUND ALERTS TO SUPPLIER)
    // =========================================================================

    public static function notifySupplierOfNewAdminOrder(AdminOrder $order)
    {
        $supplierEmail = $order->supplier->rep_email;

        self::sendMailable(
            $supplierEmail,
            "New Inbound Purchase Order Issued",
            "Procurement Request #{$order->purchase_order_number}",
            "The Gluto International procurement team has compiled a fresh replenishment purchase order targeting your wholesale inventory items assets. Please review specifications, update milestones, and attach your proforma invoice layout statement.",
            url('/supplier/orders'),
            "Open Supplier Desk Panel",
            ['PO Number' => $order->purchase_order_number, 'Grand Contract Total' => "{$order->currency} " . number_format($order->grand_total_amount, 2)]
        );
    }

    public static function notifySupplierOfOrderStatusShift(AdminOrder $order)
    {
        $supplierEmail = $order->supplier->rep_email;

        self::sendMailable(
            $supplierEmail,
            "PO Progress Milestone Modified",
            "Order #{$order->purchase_order_number} Progress Shift",
            "The Gluto International back-office administrative desk has officially moved your incoming procurement contract tracking line progress state to: [{$order->order_status}].",
            url('/supplier/orders'),
            "Review Contract Progress",
            ['PO Voucher Number' => $order->purchase_order_number, 'Global Order Status' => $order->order_status, 'Freight Shipment Status' => $order->shipment_status]
        );
    }

    /** Done
     * DYNAMIC FIX: Relays the exact administrative auditing response content and subject context down to the Supplier.
     */
    public static function notifySupplierOfAdminMessage(AdminOrder $order, string $adminSubject, string $adminMessageContent)
    {
        $supplierEmail = $order->supplier->rep_email;

        self::sendMailable(
            $supplierEmail,
            "Admin Feedback Alert: {$adminSubject}",
            "Correction Target Request inside Thread",
            "A Gluto International administrator has posted an inquiry note or verification feedback request targeting topic context [{$adminSubject}]:\n\n\"{$adminMessageContent}\"",
            url('/supplier/orders'),
            "Open Supplier Tracker Desk",
            ['PO Reference' => $order->purchase_order_number, 'Audit Subject Context' => $adminSubject]
        );
    }

    /** done
     * Notify Admin when a Supplier uploads an invoice
     */
    public static function notifyAdminOfSupplierInvoice($order, string $supplierEmail)
    {
        $subject = "Financial Operations: Vendor Invoice Uploaded";

        self::emailAllActiveAdmins(
            $subject,
            "Vendor Proforma Invoice Received",
            "A supplier profile session has attached a commercial proforma invoice to their active procurement order ledger. Please review the billing statement matrix to authorize remittance.",
            url('/admin/recent-orders'), // Adjust to the exact admin order dashboard route
            "Open Financial Dashboard",
            [
                'PO Reference Tag' => $order->purchase_order_number ?? 'N/A',
                'Vendor Contact' => $supplierEmail,
                'Pipeline Status' => 'Invoice Attached'
            ]
        );
    }

    /** done
     * Notify Supplier that their invoice was successfully processed
     */
    public static function notifySupplierOfInvoiceConfirmation($order)
    {
        // Safely resolve the email to prevent null crashes
        $supplierEmail = $order->supplier->rep_email ?? $order->supplier->email ?? 'No email provided';

        self::sendMailable(
            $supplierEmail,
            "Commercial Proforma Invoice Processed",
            "Billing Statement Sync Successful",
            "Your corporate commercial proforma invoice document has been successfully processed and cached under the Gluto International administrative dashboard pipeline ledger logs tracking indexes.",
            url('/supplier/orders'),
            "Review Inbound Orders Workspace",
            [
                'PO Reference Tag' => $order->purchase_order_number,
                'Fulfillment Status' => 'Invoice Attached'
            ]
        );
    }

    /** Done
     * Notify Admin when a Buyer uploads a Payment Receipt
     */
    public static function notifyAdminOfBuyerReceiptUpload($order, string $fileName, string $buyerEmail)
    {
        $subject = "Financial Operations: Buyer Receipt Uploaded";

        $data = [
            'subject' => $subject,
            'title' => 'Payment Verification Vault Update',
            'body' => 'A buyer profile session has appended a fresh cryptographic payment receipt payload to their procurement order ledger. Please verify the asset transfer via the financial dashboard.',
            'attributes' => [
                'Order Reference' => $order->order_ref_number ?? 'N/A',
                'Uploader Email' => $buyerEmail,
                'File Identity' => $fileName,
                'Current Progress' => $order->order_progress ?? 'Pending'
            ],
            'actionUrl' => url('/admin/recent-orders'), // Or the specific order link
            'actionText' => 'Open Financial Dashboard'
        ];

        // Assuming self::emailAllActiveAdmins is structured to accept these params,
        // OR dispatch directly to the new universal blade:
        self::emailAllActiveAdmins(
            $subject,
            $data['title'],
            $data['body'],
            $data['actionUrl'],
            $data['actionText'],
            $data['attributes'] // Passes cleanly into the general template loop
        );
    }

    /** done
     * Notify Supplier when Admin uploads a Payment Receipt
     */
    public static function notifySupplierOfAdminPaymentReceipt($order, string $fileName, string $supplierEmail)
    {
        self::sendMailable(
            $supplierEmail,
            "Financial Operations: Remittance Receipt Uploaded",
            "Payment Remittance Notice",
            "The Gluto International administrative network has dispatched and pinned a cryptographic payment remittance receipt to your vendor order ledger. Please confirm and update order status accordingly.",
            url('/supplier/dashboard'), // Adjust to your specific vendor order URL if needed
            "Access Vendor Dashboard",
            [
                'Purchase Order' => $order->purchase_order_number ?? 'N/A',
                'File Identity' => $fileName,
                'Pipeline Status' => $order->order_status ?? 'Pending'
            ]
        );
    }

    /** Done
     * Notify Buyer when Admin uploads a Commercial Invoice
     */
    public static function notifyBuyerOfAdminInvoice($order, string $fileName, string $buyerEmail)
    {
        self::sendMailable(
            $buyerEmail,
            "Financial Operations: Commercial Invoice Issued",
            "Billing Statement Sync",
            "The Gluto International administrative network has issued a commercial invoice for your procurement order request. Please review the billing matrix to proceed with the transaction transfer.",
            url('/buyer/dashboard'), // Adjust to the specific buyer order URL if needed
            "Access Buyer Console",
            [
                'Order Reference' => $order->order_ref_number ?? 'N/A',
                'File Identity' => $fileName,
                'Pipeline Status' => 'Invoice Issued'
            ]
        );
    }

    /**
     * Notify Buyer when Admin updates Order or Shipment Status
     */
    public static function notifyBuyerOfStatusUpdate($order, string $statusType, string $newStatus, string $buyerEmail)
    {
        self::sendMailable(
            $buyerEmail,
            "Logistics Operations: {$statusType} Updated",
            "Pipeline Status Modification",
            "The Gluto International administrative network has formally updated the {$statusType} constraint for your procurement pipeline request. Please evaluate your operations dashboard for active timeline metrics.",
            url('/buyer/dashboard'), // Adjust to the specific buyer dashboard/order route if needed
            "Access Buyer Console",
            [
                'Order Reference' => $order->order_ref_number ?? 'N/A',
                'Tracking Category' => $statusType,
                'New Pipeline Status' => $newStatus
            ]
        );
    }

    /**
     * Notify Admin when a Supplier updates Order or Shipment Status
     */
    public static function notifyAdminOfSupplierStatusUpdate($order, string $statusType, string $newStatus, string $supplierEmail)
    {
        $subject = "Logistics Operations: Vendor {$statusType} Updated";

        self::emailAllActiveAdmins(
            $subject,
            "Vendor Pipeline Status Modification",
            "A supplier profile session has updated the {$statusType} constraint for their active procurement order. Please evaluate the administrative operations dashboard for active timeline metrics.",
            url('/admin/recent-orders'), // Adjust to your specific admin order dashboard route
            "Open Operations Dashboard",
            [
                'Purchase Order' => $order->purchase_order_number ?? 'N/A',
                'Vendor Contact' => $supplierEmail,
                'Tracking Category' => $statusType,
                'New Pipeline Status' => $newStatus
            ]
        );
    }

    /**
     * Notify Supplier when Admin toggles their compliance verification status
     */
    public static function notifySupplierOfVerificationStatus($supplier, string $newStatus)
    {
        // Safely resolve the email to prevent null type errors
        $supplierEmail = $supplier->rep_email ?? $supplier->email ?? 'No email provided';

        $isVerified = $newStatus === 'Verified Supplier';

        $subject = $isVerified ? "Compliance Operations: Profile Verified" : "Compliance Operations: Profile Unverified";
        $title = $isVerified ? "Vendor Compliance Verification Approved" : "Vendor Compliance Verification Revoked";

        $body = $isVerified
            ? "Your corporate supplier profile has successfully passed Gluto International's administrative compliance checks. Your vendor node is now fully active."
            : "Your corporate supplier profile has been marked as unverified by the Gluto International administrative network. Procurement pipeline routing to your vendor node has been temporarily suspended pending further compliance review.";

        self::sendMailable(
            $supplierEmail,
            $subject,
            $title,
            $body,
            url('/supplier/dashboard'),
            "Access Vendor Node",
            [
                'Profile Name'     => $supplier->company_name ?? 'N/A',
                'Compliance State' => $newStatus,
                'Network Access'   => $isVerified ? 'VERIFIED SUPPLIER' : 'UNVERIFIED SUPPLIER'
            ]
        );
    }

    /**
     * Notify Buyer when Admin updates their compliance verification status
     */
    public static function notifyBuyerOfVerificationStatus($buyer, string $newStatus)
    {
        // Safely resolve the email to prevent null type errors
        $buyerEmail = $buyer->rep_email ?? $buyer->email ?? 'No email provided';

        // Base messaging
        $subject = "Compliance Operations: Profile Status Updated";
        $title = "Buyer Compliance Network Update";
        $body = "Your corporate buyer profile status has been formally updated by the Gluto International administrative network. Please review your active clearance metrics.";
        $networkAccess = 'PENDING REVIEW';

        // Dynamic messaging adjustments based on specific status milestones
        if ($newStatus === 'Verified Buyer') {
            $subject = "Compliance Operations: Profile Verified";
            $title = "Buyer Compliance Verification Approved";
            $body = "Your corporate buyer profile has successfully passed Gluto International's administrative compliance checks. Your procurement node is now fully active and authorized to dispatch RFQs.";
            $networkAccess = 'ACTIVE';
        } elseif ($newStatus === 'Unprocessed Buyer') {
            $subject = "Compliance Operations: Profile Unverified";
            $title = "Buyer Compliance Verification Revoked";
            $body = "Your corporate buyer profile has been marked as unverified by the Gluto International administrative network. Procurement pipeline routing from your node has been temporarily suspended pending further compliance review.";
            $networkAccess = 'UNVERIFIED';
        }

        self::sendMailable(
            $buyerEmail,
            $subject,
            $title,
            $body,
            url('/buyer/dashboard'),
            "Access Buyer Node",
            [
                'Profile Name' => $buyer->company_name ?? 'N/A',
                'Compliance State' => $newStatus,
                'Network Access' => $networkAccess
            ]
        );
    }
}
