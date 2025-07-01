<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password With Resend</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom font for Inter */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Forgot Password With Resend and locked steps</h2>

        <div id="step-1">
            <form id="find-account-form" class="space-y-4">
                <input type="text" id="email_or_phone" name="email_or_phone" placeholder="Enter your email or phone" required
                       class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                        class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                    Find My Account
                </button>
            </form>
        </div>

        <div id="step-2" class="hidden">
            <div id="user-found" class="hidden">
                <div class="flex flex-col items-center mb-4">
                    <p id="user-name" class="text-lg font-semibold text-gray-900"></p>
                    <p id="user-message" class="text-gray-600 text-center"></p>
                </div>

                <form id="recovery-options" class="space-y-3">
                    <div id="email-option" class="option hidden flex items-center p-3 border border-gray-200 rounded-md">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="radio" name="recovery" value="email" class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700"></span>
                        </label>
                    </div>
                    <div id="phone-option" class="option hidden flex items-center p-3 border border-gray-200 rounded-md">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="radio" name="recovery" value="phone" class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700"></span>
                        </label>
                    </div>
                    <div class="option flex items-center p-3 border border-gray-200 rounded-md">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="radio" name="recovery" value="login" class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700">Login with Password</span>
                        </label>
                    </div>
                    <div class="option flex items-center p-3 border border-gray-200 rounded-md">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="radio" name="recovery" value="contact" class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700">No longer have access - Contact Authority</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                        Continue
                    </button>
                </form>
            </div>

            <div id="user-not-found" class="hidden text-center mt-6">
                <p class="text-red-600 mb-4">No user found with given credentials.</p>
                <button onclick="goBack()"
                        class="bg-gray-200 text-gray-800 p-3 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition ease-in-out duration-150">
                    Back
                </button>
            </div>
        </div>

        <div id="step-3" class="hidden">
            <p id="otp-message" class="text-gray-700 mb-4 text-center"></p>

            <div id="otp-input-section" class="hidden">
                <form id="otpForm" class="space-y-4">
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required
                           class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                            class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                        Verify OTP
                    </button>
                </form>
                <div class="text-center mt-4">
                    <p id="otp-timer" class="text-sm text-gray-500 mb-2">Resend OTP in 3 seconds</p>
                    <button id="resend-otp-button" disabled
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150">
                        Didn't get OTP? Resend OTP
                    </button>
                </div>
            </div>

            <div id="thank-you-message" class="hidden text-center mt-6">
                <p class="text-green-600 text-lg font-semibold">Thanks! We will be in touch very soon.</p>
                <button onclick="goBack()"
                        class="mt-4 bg-gray-200 text-gray-800 p-3 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition ease-in-out duration-150">
                    Back to Start
                </button>
            </div>

            <div id="reset-password-section" class="hidden">
                <form id="reset-password-form" class="space-y-4">
                    <input type="password" id="new-password" placeholder="New Password" required
                           class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="password" id="confirm-password" placeholder="Confirm New Password" required
                           class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                            class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>

        <a href="/landing" id="back-to-home-link" class="block text-center text-blue-600 hover:underline mt-6">Back to Home</a>
    </div>

    <div id="custom-alert-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm text-center">
            <p id="custom-alert-message" class="text-gray-800 text-lg mb-4"></p>
            <button id="custom-alert-ok-button" class="bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 w-24">OK</button>
        </div>
    </div>

    <script>
        // Global variable to store user data after finding account
        let currentUser = null;
        let currentOtpSendTo = ''; // Stores the email or phone where OTP was sent
        let currentOtpType = 'password-recovery'; // Stores the type of OTP (fixed for this flow)
        let timerIntervalId = null; // Stores the interval ID for the OTP timer
        const OTP_COOLDOWN_SECONDS = 3; // Cooldown duration for OTP resend
        let isInProgress = false; // New flag to track if the process is active

        // DOM element references for easier access
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const step3 = document.getElementById('step-3');

        const findAccountForm = document.getElementById('find-account-form');
        const emailOrPhoneInput = document.getElementById('email_or_phone');

        const userFoundDiv = document.getElementById('user-found');
        const userNameElem = document.getElementById('user-name');
        const userMessageElem = document.getElementById('user-message');
        const userNotFoundDiv = document.getElementById('user-not-found');

        const recoveryOptionsForm = document.getElementById('recovery-options');
        const emailOptionDiv = document.getElementById('email-option');
        const phoneOptionDiv = document.getElementById('phone-option');

        const otpMessageElem = document.getElementById('otp-message');
        const otpInputSection = document.getElementById('otp-input-section');
        const otpForm = document.getElementById('otpForm');
        const otpInput = document.getElementById('otp');
        const thankYouMessageDiv = document.getElementById('thank-you-message');
        const resetPasswordSection = document.getElementById('reset-password-section');
        const resetPasswordForm = document.getElementById('reset-password-form');
        const newPasswordInput = document.getElementById('new-password');
        const confirmPasswordInput = document.getElementById('confirm-password');

        const otpTimerElem = document.getElementById('otp-timer');
        const resendOtpButton = document.getElementById('resend-otp-button');

        const customAlertModal = document.getElementById('custom-alert-modal');
        const customAlertMessage = document.getElementById('custom-alert-message');
        const customAlertOkButton = document.getElementById('custom-alert-ok-button');
        const backToHomeLink = document.getElementById('back-to-home-link');


        /**
         * Masks an email address for display (e.g., "ex**@d***.com").
         * @param {string} email - The email address to mask.
         * @returns {string} The masked email address.
         */
        function maskEmail(email) {
            if (!email || typeof email !== 'string' || !email.includes('@')) return '';
            const [username, domain] = email.split('@');
            const maskedUsername = username.slice(0, 2) + '*'.repeat(Math.max(username.length - 2, 0));

            const domainParts = domain.split('.');
            let domainName = domainParts[0] || '';
            const tld = domainParts.slice(1).join('.') || '';

            const domainMasked = domainName.slice(0, 1) + '*'.repeat(Math.max(domainName.length - 1, 0));

            return `${maskedUsername}@${domainMasked}.${tld}`;
        }

        /**
         * Masks a phone number for display (e.g., "********1234").
         * @param {string} phone - The phone number to mask.
         * @returns {string} The masked phone number.
         */
        function maskPhone(phone) {
            if (!phone || typeof phone !== 'string') return '';
            const last4 = phone.slice(-4);
            return '*'.repeat(Math.max(phone.length - 4, 0)) + last4;
        }

        /**
         * Displays a custom alert modal with a given message.
         * @param {string} message - The message to display.
         */
        function showCustomAlert(message) {
            customAlertMessage.textContent = message;
            customAlertModal.classList.remove('hidden');
        }

        /**
         * Hides the custom alert modal.
         */
        function hideCustomAlert() {
            customAlertModal.classList.add('hidden');
        }

        /**
         * Controls which step of the forgot password flow is visible.
         * Hides all steps first, then shows the specified step.
         * @param {string} stepId - The ID of the step to show ('step-1', 'step-2', 'step-3').
         */
        function showStep(stepId) {
            // Hide all steps
            step1.classList.add('hidden');
            step2.classList.add('hidden');
            step3.classList.add('hidden');

            // Set isInProgress flag
            if (stepId === 'step-1') {
                isInProgress = false;
            } else {
                isInProgress = true;
            }

            // Show the requested step and manage its initial sub-section visibility
            switch (stepId) {
                case 'step-1':
                    step1.classList.remove('hidden');
                    break;
                case 'step-2':
                    step2.classList.remove('hidden');
                    // Ensure user-found and user-not-found are managed by the fetch logic
                    userFoundDiv.classList.add('hidden');
                    userNotFoundDiv.classList.add('hidden');
                    break;
                case 'step-3':
                    step3.classList.remove('hidden');
                    // By default, hide all sub-sections of step 3
                    otpInputSection.classList.add('hidden');
                    thankYouMessageDiv.classList.add('hidden');
                    resetPasswordSection.classList.add('hidden');
                    break;
                default:
                    console.error("Invalid step ID provided:", stepId);
            }
        }

        /**
         * Resets the flow back to Step 1 and clears the input field.
         * Optionally takes a boolean to force going back without a warning.
         * @param {boolean} [force=false] - If true, goes back without prompt.
         */
        function goBack(force = false) {
            if (isInProgress && !force) {
                if (!confirm("Are you sure you want to abandon the password reset process? You will lose your progress.")) {
                    return; // User clicked Cancel
                }
            }
            showStep('step-1');
            emailOrPhoneInput.value = '';
            currentUser = null; // Clear any stored user data
            clearOtpTimer(); // Clear timer if navigating back from OTP step
            isInProgress = false; // Reset the flag
        }

        /**
         * Starts the OTP resend cooldown timer.
         * @param {number} duration - The duration of the cooldown in seconds.
         */
        function startOtpTimer(duration) {
            clearOtpTimer(); // Clear any existing timer first
            resendOtpButton.disabled = true;
            let secondsRemaining = duration;

            otpTimerElem.textContent = `Resend OTP in ${secondsRemaining} seconds`;

            timerIntervalId = setInterval(() => {
                secondsRemaining--;
                if (secondsRemaining > 0) {
                    otpTimerElem.textContent = `Resend OTP in ${secondsRemaining} seconds`;
                } else {
                    clearOtpTimer();
                    resendOtpButton.disabled = false;
                    otpTimerElem.textContent = "Didn't get OTP?";
                }
            }, 1000);
        }

        /**
         * Clears the OTP resend timer.
         */
        function clearOtpTimer() {
            if (timerIntervalId) {
                clearInterval(timerIntervalId);
                timerIntervalId = null;
            }
        }

        /**
         * Generic function to send an OTP, used by both initial send and resend.
         * @param {string} method - 'email' or 'phone'.
         * @param {string} recipient - The email or phone number.
         */
        async function triggerOtpSend(method, recipient) {
            let apiUrl = '';
            let requestBody = {};

            if (method === 'email') {
                apiUrl = '/send-otp-email';
                requestBody = { email: recipient, userId: currentUser.id };
            } else if (method === 'phone') {
                apiUrl = '/send-otp-phone';
                requestBody = { phone: recipient, userId: currentUser.id };
            } else {
                showCustomAlert("Invalid OTP sending method specified.");
                return false;
            }

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(requestBody)
                });

                if (!response.ok) {
                    const errorData = await response.json(); // Attempt to parse error message
                    throw new Error(errorData.message || `Server responded with status: ${response.status}`);
                }

                const data = await response.json();

                if (data.result || data.success) { // Assuming result for email, success for phone
                    startOtpTimer(OTP_COOLDOWN_SECONDS);
                    return true;
                } else {
                    showCustomAlert(data.message || `Failed to send OTP. Please try again.`);
                    return false;
                }
            } catch (error) {
                console.error('Error sending OTP:', error);
                showCustomAlert(`An error occurred while sending the OTP: ${error.message}. Please try again.`);
                return false;
            }
        }


        // --- Event Listeners ---

        // Event listener for the custom alert's OK button
        customAlertOkButton.addEventListener('click', hideCustomAlert);

        // Handle the submission of the "Find My Account" form (Step 1)
        findAccountForm.addEventListener('submit', async function (e) {
            e.preventDefault(); // Prevent default form submission
            const email_or_phone = emailOrPhoneInput.value.trim();

            if (!email_or_phone) {
                showCustomAlert("Please enter your email or phone number.");
                return;
            }

            try {
                const response = await fetch('/check-user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email_or_phone: email_or_phone })
                });

                if (!response.ok) {
                    throw new Error(`Server responded with status: ${response.status}`);
                }

                const data = await response.json();

                showStep('step-2'); // Always move to step 2 to show either user found or not found

                if (data.result === true && data.code === 200 && data.data) {
                    currentUser = data.data;
                    userFoundDiv.classList.remove('hidden');
                    userNotFoundDiv.classList.add('hidden');

                    userNameElem.textContent = currentUser.name;
                    userMessageElem.textContent = `${currentUser.name}, is this you?`;

                    const emailLabelSpan = emailOptionDiv.querySelector('span');
                    const phoneLabelSpan = phoneOptionDiv.querySelector('span');

                    if (currentUser.email) {
                        emailOptionDiv.classList.remove('hidden');
                        emailLabelSpan.textContent = `Send OTP to ${maskEmail(currentUser.email)}`;
                    } else {
                        emailOptionDiv.classList.add('hidden');
                        emailLabelSpan.textContent = '';
                    }

                    if (currentUser.phone) {
                        phoneOptionDiv.classList.remove('hidden');
                        phoneLabelSpan.textContent = `Send OTP to ${maskPhone(currentUser.phone)}`;
                    } else {
                        phoneOptionDiv.classList.add('hidden');
                        phoneLabelSpan.textContent = '';
                    }
                } else {
                    userFoundDiv.classList.add('hidden');
                    userNotFoundDiv.classList.remove('hidden');
                    currentUser = null;
                }
            } catch (error) {
                console.error('Error finding account:', error);
                showCustomAlert("An error occurred while trying to find your account. Please check your input and try again.");
                showStep('step-1'); // Go back to step 1 on a general error
            }
        });

        // Handle the submission of the "Continue" form with recovery options (Step 2)
        recoveryOptionsForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const selectedOption = document.querySelector('input[name="recovery"]:checked');

            if (!selectedOption) {
                showCustomAlert("Please select a recovery option to continue.");
                return;
            }

            const option = selectedOption.value;
            showStep('step-3'); // Transition to step 3 immediately

            let otpSent = false;

            if (option === 'email') {

                if (!currentUser || !currentUser.email) {
                    showCustomAlert("Email recovery is not available for this account.");
                    goBack(true); // Force goBack as it's an internal logic issue
                    return;
                }
                otpMessageElem.textContent = `An OTP has been sent to your registered email ${maskEmail(currentUser.email)}. Please enter it below to proceed.`;
                otpInputSection.classList.remove('hidden');

                // Explicitly set global context variables
                currentOtpSendTo = currentUser.email;
                currentOtpType = 'email';
                otpSent = await triggerOtpSend(currentOtpType, currentOtpSendTo);

            } else if (option === 'phone') {
                if (!currentUser || !currentUser.phone) {
                    showCustomAlert("Phone recovery is not available for this account.");
                    goBack(true); // Force goBack as it's an internal logic issue
                    return;
                }
                otpMessageElem.textContent = `An OTP has been sent to your registered phone ${maskPhone(currentUser.phone)}. Please enter it below to proceed.`;
                otpInputSection.classList.remove('hidden');

                // Explicitly set global context variables
                currentOtpSendTo = currentUser.phone;
                currentOtpType = 'phone';
                otpSent = await triggerOtpSend(currentOtpType, currentOtpSendTo);

            } else if (option === 'login') {
                // If user selects "Login with Password", redirect without warning.
                // We mark isInProgress as false so beforeunload doesn't fire.
                isInProgress = false;
                window.location.href = '/login';
                return; // Stop execution
            } else if (option === 'contact') {
                otpMessageElem.textContent = "";
                thankYouMessageDiv.classList.remove('hidden');
                // For "Contact Authority", we consider the process completed for this path
                isInProgress = false;
                return; // Stop execution
            }

            if (!otpSent) {
                goBack(true); // If OTP failed to send, go back to step 1 forcefully
            }
        });

        // Handle resend OTP button click
        resendOtpButton.addEventListener('click', async function() {
            if (!resendOtpButton.disabled) { // Double check if enabled
                otpInput.value = ''; // Reset OTP input field
                const otpSent = await triggerOtpSend(currentOtpType, currentOtpSendTo);
                if (otpSent) {
                    showCustomAlert(`A new OTP has been sent to your ${currentOtpType}.`);
                }
            }
        });

        // Handle the submission of the OTP verification form (Step 3)
        otpForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const otp = otpInput.value.trim();

            if (!otp) {
                showCustomAlert("Please enter the OTP you received.");
                return;
            }

            // Ensure currentOtpSendTo and currentOtpType are set from previous steps
            if (!currentOtpSendTo || !currentOtpType) {
                showCustomAlert("OTP context missing. Please restart the process.");
                goBack(true); // Force goBack
                return;
            }

            try {
                const response = await fetch('/verify-reset-password-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        otp: otp,
                        send_to: currentOtpSendTo,
                        type: 'password-recovery'
                    })
                });
                console.log(response);
                if (!response.ok) {
                    const errorData = await response.json();
                    if (response.status === 422 && errorData.errors) {
                        let errorMessage = 'Validation failed:';
                        for (const field in errorData.errors) {
                            errorMessage += `\n- ${errorData.errors[field].join(', ')}`;
                        }
                        showCustomAlert(errorMessage);
                    } else {
                        throw new Error(`Server responded with status: ${response.status}. Message: ${errorData.message || 'Unknown error.'}`);
                    }
                    return;
                }
                const data = await response.json();
                console.log(data);
                if (data.result === true) {
                    clearOtpTimer();
                    otpInputSection.classList.add('hidden');
                    otpMessageElem.textContent = "OTP verified successfully! Please set your new password below.";
                    resetPasswordSection.classList.remove('hidden');
                } else {
                    showCustomAlert(data.message || "The OTP you entered is invalid or expired. Please check and try again.");
                }
            } catch (error) {
                console.error('Error verifying OTP:', error);
                showCustomAlert("An error occurred during OTP verification. Please try again.");
            }
        });

        // Handle the submission of the "Reset Password" form (Step 3)
        resetPasswordForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (newPassword !== confirmPassword) {
                showCustomAlert("New password and confirm password do not match.");
                return;
            }
            if (newPassword.length < 6) {
                showCustomAlert("Your new password must be at least 6 characters long.");
                return;
            }

            if (!currentUser || !currentUser.id) {
                showCustomAlert("User information is missing. Please restart the password reset process.");
                goBack(true); // Force goBack
                return;
            }

            try {
                const response = await fetch('/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        userId: currentUser.id,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    if (response.status === 422 && errorData.errors) {
                        let errorMessage = 'Validation failed:';
                        for (const field in errorData.errors) {
                            errorMessage += `\n- ${errorData.errors[field].join(', ')}`;
                        }
                        showCustomAlert(errorMessage);
                    } else {
                        throw new Error(`Server responded with status: ${response.status}. Message: ${errorData.message || 'Unknown error.'}`);
                    }
                    return;
                }
                const data = await response.json();

                if (data.result === true) {
                    showCustomAlert("Your password has been successfully reset! You will now be redirected to the login page.");
                    isInProgress = false; // Process is complete, no warning needed on redirect
                    setTimeout(() => window.location.href = '/landing-login', 2000);
                } else {
                    showCustomAlert(data.message || "Failed to reset your password. Please try again.");
                }
            } catch (error) {
                console.error('Error resetting password:', error);
                showCustomAlert("An error occurred during the password reset process. Please try again.");
            }
        });

        // --- New Logic for Exit Warning ---

        /**
         * Event listener for the `beforeunload` event.
         * Shows a confirmation dialog if the password reset process is in progress.
         * @param {Event} e - The beforeunload event object.
         */
        window.addEventListener('beforeunload', function (e) {
            if (isInProgress) {
                // Most browsers now ignore the custom message and display a generic one.
                // However, returning a string is still necessary to trigger the dialog.
                const confirmationMessage = "Are you sure you want to leave? Your password reset progress will be lost.";
                e.returnValue = confirmationMessage; // Standard for older browsers
                return confirmationMessage; // For modern browsers
            }
        });

        // Intercept clicks on the "Back to Home" link
        backToHomeLink.addEventListener('click', function (e) {
            if (isInProgress) {
                e.preventDefault(); // Prevent default navigation
                if (confirm("Are you sure you want to abandon the password reset process and go back to home? You will lose your progress.")) {
                    isInProgress = false; // Allow navigation after confirmation
                    window.location.href = e.target.href; // Proceed with navigation
                }
            }
        });


        // Initialize the flow by showing the first step when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            showStep('step-1');
        });
    </script>
</body>
</html>