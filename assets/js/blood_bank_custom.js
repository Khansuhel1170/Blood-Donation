document.addEventListener('DOMContentLoaded', function() {
        var message = document.getElementById('message');
        var closeBtn = document.getElementById('close-message');

        setTimeout(function() {
            hideMessage();
        }, 20000);

        // Function to hide message
        function hideMessage() {
            message.classList.add('hidden');
        }

        // Event listener for close button
        closeBtn.addEventListener('click', function() {
            hideMessage();
        });
    });