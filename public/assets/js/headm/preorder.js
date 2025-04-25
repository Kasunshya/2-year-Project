/**
 * PreOrder JavaScript - Handles enquiry reply functionality
 * This file manages the modal display and form submission for replying to customer enquiries
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Preorder script loaded');

    // Make showReplyModal globally accessible so it can be called from inline onclick
    window.showReplyModal = function(enquiry_id, customerName, customerEmail) {
        console.log('Modal triggered for:', enquiry_id, customerName, customerEmail);
        
        // Set values in the modal
        document.getElementById('enquiry_id').value = enquiry_id;
        document.getElementById('customer_name').textContent = customerName;
        document.getElementById('customer_email').textContent = customerEmail;
        
        // Show modal with jQuery
        $('#replyModal').modal('show');
    };

    // Handle form submission
    if (document.getElementById('replyForm')) {
        document.getElementById('replyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted');
            
            const enquiry_id = document.getElementById('enquiry_id').value;
            const reply_message = document.getElementById('reply_message').value;
            
            // Use absolute URL for fetch
            fetch(window.location.origin + '/Bakery/HeadM/sendEnquiryReply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `enquiry_id=${encodeURIComponent(enquiry_id)}&reply_message=${encodeURIComponent(reply_message)}`
            })
            .then(response => {
                console.log('Response received:', response);
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.status === 'success') {
                    alert('Reply sent successfully!');
                    $('#replyModal').modal('hide');
                    // Clear the textarea for next use
                    document.getElementById('reply_message').value = '';
                } else {
                    alert('Failed to send reply: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending the reply');
            });
        });
    } else {
        console.error('Reply form not found in the document');
    }

    // For debugging: check if Bootstrap and jQuery are properly loaded
    console.log('jQuery version:', typeof $ !== 'undefined' ? $.fn.jquery : 'not loaded');
    console.log('Bootstrap modal:', typeof $.fn.modal !== 'undefined' ? 'loaded' : 'not loaded');
});