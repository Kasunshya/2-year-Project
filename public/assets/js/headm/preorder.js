/**
 * PreOrder JavaScript - Handles enquiry reply functionality
 * This file manages the modal display and form submission for replying to customer enquiries
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Preorder script loaded');

    // Make showReplyModal globally accessible so it can be called from inline onclick
    window.showReplyModal = function(enquiryId, customerName, customerEmail) {
        document.getElementById('enquiry_id').value = enquiryId;
        document.getElementById('customer_name').textContent = customerName;
        document.getElementById('customer_email').textContent = customerEmail;
        $('#replyModal').modal('show');
    };

    // Handle form submission
    if (document.getElementById('replyForm')) {
        document.getElementById('replyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                enquiry_id: document.getElementById('enquiry_id').value,
                reply_message: document.getElementById('reply_message').value
            };

            fetch(`${URLROOT}/HeadM/sendReply`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                $('#replyModal').modal('hide');
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Reply sent successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message || 'Something went wrong!'
                    });
                }
            })
            .catch(error => {
                $('#replyModal').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to send reply. Please try again.'
                });
            });
        });
    } else {
        console.error('Reply form not found in the document');
    }

    // Add confirmation for closing modal with unsaved changes
    $('#replyModal').on('hide.bs.modal', function (e) {
        const replyMessage = document.getElementById('reply_message').value;
        if (replyMessage.trim() !== '') {
            e.preventDefault();
            Swal.fire({
                title: 'Discard changes?',
                text: 'Your reply message will be lost.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, discard',
                cancelButtonText: 'No, keep editing'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reply_message').value = '';
                    $('#replyModal').modal('hide');
                }
            });
        }
    });

    // For debugging: check if Bootstrap and jQuery are properly loaded
    console.log('jQuery version:', typeof $ !== 'undefined' ? $.fn.jquery : 'not loaded');
    console.log('Bootstrap modal:', typeof $.fn.modal !== 'undefined' ? 'loaded' : 'not loaded');
});