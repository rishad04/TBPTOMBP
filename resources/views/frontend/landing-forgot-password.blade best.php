<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS CDN for styling -->
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

    <!-- Main container for the form, centered and responsive -->
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Forgot Password</h2>

        <!-- Step 1: Find Account -->
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

        <!-- Step 2: Recovery Options -->
        <div id="step-2" class="hidden">
            <div id="user-found" class="hidden">
                <div class="flex flex-col items-center mb-4">
                    <!-- Placeholder for user image if needed: <img id="user-image" src="https://placehold.co/100x100/A3A3A3/FFFFFF?text=User" alt="User Image" class="rounded-full mb-2"> -->
                    <p id="user-name" class="text-lg font-semibold text-gray-900"></p>
                    <p id="user-message" class="text-gray-600 text-center"></p>
                </div>

                <form id="recovery-options" class="space-y-3">
                    <!-- Email recovery option, hidden if email is not available -->
                    <div id="email-option" class="option hidden flex items-center p-3 border border-gray-200 rounded-md">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="radio" name="recovery" value="email" class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700"></span>
                        </label>
                    </div>
                    <!-- Phone recovery option, hidden if phone is not available -->
                    <div id="phone-option" class="option hidden flex items-center p-3 border border-gray-200 rounded-md">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="radio" name="recovery" value="phone" class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700"></span>
                        </label>
                    </div>
                    <!-- Login with password option -->
                    <div class="option flex items-center p-3 border border-gray-200 rounded-md">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="radio" name="recovery" value="login" class="form-radio h-4 w-4 text-blue-600">
                            <span class="ml-2 text-gray-700">Login with Password</span>
                        </label>
                    </div>
                    <!-- Contact authority option -->
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

            <!-- Message if user account is not found -->
            <div id="user-not-found" class="hidden text-center mt-6">
                <p class="text-red-600 mb-4">No user found with given credentials.</p>
                <button onclick="goBack()"
                        class="bg-gray-200 text-gray-800 p-3 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition ease-in-out duration-150">
                    Back
                </button>
            </div>
        </div>

        <!-- Step 3: OTP and Reset Password / Thank You Message -->
        <div id="step-3" class="hidden">
            <p id="otp-message" class="text-gray-700 mb-4 text-center"></p>

            <!-- OTP input section, shown for email/phone recovery -->
            <div id="otp-input-section" class="hidden">
                <form id="otpForm" class="space-y-4">
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required
                           class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                            class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                        Verify OTP
                    </button>
                </form>
            </div>

            <!-- Thank you message, shown for 'contact authority' option -->
            <div id="thank-you-message" class="hidden text-center mt-6">
                <p class="text-green-600 text-lg font-semibold">Thanks! We will be in touch very soon.</p>
                <button onclick="goBack()"
                        class="mt-4 bg-gray-200 text-gray-800 p-3 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition ease-in-out duration-150">
                    Back to Start
                </button>
            </div>

            <!-- Reset password section, shown after successful OTP verification -->
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

        <a href="/landing" class="block text-center text-blue-600 hover:underline mt-6">Back to Home</a>
    </div>

    <!-- Custom Alert Modal: Replaces default alert() for better UX -->
    <div id="custom-alert-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm text-center">
            <p id="custom-alert-message" class="text-gray-800 text-lg mb-4"></p>
            <button id="custom-alert-ok-button" class="bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 w-24">OK</button>
        </div>
    </div>

    <script>
        // Global variable to store user data after finding account
        let currentUser = null;

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

        const customAlertModal = document.getElementById('custom-alert-modal');
        const customAlertMessage = document.getElementById('custom-alert-message');
        const customAlertOkButton = document.getElementById('custom-alert-ok-button');

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
         */
        function goBack() {
            showStep('step-1');
            emailOrPhoneInput.value = '';
            currentUser = null; // Clear any stored user data
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
                // Simulate API call to check if a user exists
                const response = await fetch('/check-user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
                    },
                    body: JSON.stringify({ email_or_phone: email_or_phone })
                });

                if (!response.ok) {
                    // Handle non-2xx HTTP responses (e.g., 404, 500)
                    throw new Error(`Server responded with status: ${response.status}`);
                }

                const data = await response.json(); // Parse the JSON response

                showStep('step-2'); // Move to step 2 to show user found/not found

                if (data.result === true && data.code === 200 && data.data) {
                    currentUser = data.data; // Store the user data
                    userFoundDiv.classList.remove('hidden');
                    userNotFoundDiv.classList.add('hidden');

                    userNameElem.textContent = currentUser.name;
                    userMessageElem.textContent = `${currentUser.name}, is this you?`;

                    // Update recovery options with masked contact details
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
                    // If user not found or API returns an error
                    userFoundDiv.classList.add('hidden');
                    userNotFoundDiv.classList.remove('hidden');
                    currentUser = null; // Clear user data
                }
            } catch (error) {
                console.error('Error finding account:', error);
                showCustomAlert("An error occurred while trying to find your account. Please check your input and try again.");
                showStep('step-1'); // Go back to step 1 on a critical error
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

            if (option === 'email') {
                if (!currentUser || !currentUser.email) {
                    showCustomAlert("Email recovery is not available for this account.");
                    goBack();
                    return;
                }
                otpMessageElem.textContent = `An OTP has been sent to your registered email ${maskEmail(currentUser.email)}. Please enter it below to proceed.`;
                otpInputSection.classList.remove('hidden'); // Show OTP input

                try {
                    // Simulate API call to send OTP via email
                    const response = await fetch('/send-otp-email', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ email: currentUser.email, userId: currentUser.id })
                    });

                    if (!response.ok) {
                        throw new Error(`Server responded with status: ${response.status}`);
                    }
                    const data = await response.json();

                    if (!data.result) {
                        showCustomAlert("Failed to send OTP to email. Please try again.");
                        goBack(); // Return to start if OTP sending failed
                    }
                } catch (error) {
                    console.error('Error sending OTP to email:', error);
                    showCustomAlert("An error occurred while sending the OTP to your email. Please try again.");
                    goBack();
                }

            } else if (option === 'phone') {
                if (!currentUser || !currentUser.phone) {
                    showCustomAlert("Phone recovery is not available for this account.");
                    goBack();
                    return;
                }
                otpMessageElem.textContent = `An OTP has been sent to your registered phone ${maskPhone(currentUser.phone)}. Please enter it below to proceed.`;
                otpInputSection.classList.remove('hidden'); // Show OTP input

                try {
                    // Simulate API call to send OTP via phone
                    const response = await fetch('/send-otp-phone', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ phone: currentUser.phone, userId: currentUser.id })
                    });

                    if (!response.ok) {
                        throw new Error(`Server responded with status: ${response.status}`);
                    }
                    const data = await response.json();

                    if (!data.result) { // Assuming 'success' property for phone OTP response
                        showCustomAlert("Failed to send OTP to phone. Please try again.");
                        goBack();
                    }
                } catch (error) {
                    console.error('Error sending OTP to phone:', error);
                    showCustomAlert("An error occurred while sending the OTP to your phone. Please try again.");
                    goBack();
                }

            } else if (option === 'login') {
                window.location.href = '/login'; // Redirect to login page
            } else if (option === 'contact') {
                otpMessageElem.textContent = ""; // Clear any OTP message
                thankYouMessageDiv.classList.remove('hidden'); // Show the 'thank you' message
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

            let selectedSendTo = '';
            let otpPurposeType = 'password-recovery'; // Define the type

            // This part assumes you know whether the OTP was sent to email or phone
            // based on the user's previous selection in Step 2.
            // You might need a global variable or store it in localStorage/sessionStorage.
            if (currentUser && currentUser.email && document.querySelector('input[name="recovery"][value="email"]:checked')) {
                selectedSendTo = currentUser.email;
            } else if (currentUser && currentUser.phone && document.querySelector('input[name="recovery"][value="phone"]:checked')) {
                selectedSendTo = currentUser.phone;
            } else {
                // Fallback or error if send_to can't be determined
                showCustomAlert("Could not determine where the OTP was sent. Please restart the process.");
                return;
            }

            try {
                // Simulate API call to verify the entered OTP
                const response = await fetch('/verify-reset-password-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                      otp: otp,
                      send_to: selectedSendTo, // Send the email or phone number
                      type: otpPurposeType     // Send the OTP type
                     })
                });

                if (!response.ok) {
                    throw new Error(`Server responded with status: ${response.status}`);
                }
                const data = await response.json();

                if (data.result === true) { // Assuming 'result' indicates successful OTP verification
                    otpInputSection.classList.add('hidden'); // Hide OTP input section
                    otpMessageElem.textContent = "OTP verified successfully! Please set your new password below.";
                    resetPasswordSection.classList.remove('hidden'); // Show the reset password form
                } else {
                    showCustomAlert("The OTP you entered is invalid. Please check and try again.");
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
            if (newPassword.length < 6) { // Example: enforce minimum password length
                showCustomAlert("Your new password must be at least 6 characters long.");
                return;
            }

            try {
                // Simulate API call to reset the user's password
                const response = await fetch('/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                      userId: currentUser.id, // <--- IMPORTANT: Send the user ID here
                      new_password: newPassword,
                      confirm_password: confirmPassword
                     })
                });

                if (!response.ok) {
                    throw new Error(`Server responded with status: ${response.status}`);
                }
                const data = await response.json();

                if (data.result === true) { // Assuming 'result' indicates successful password reset
                    showCustomAlert("Your password has been successfully reset! You will now be redirected to the login page.");
                    // Redirect to login page after a short delay
                    setTimeout(() => window.location.href = '/landing-login', 2000);
                } else {
                    showCustomAlert("Failed to reset your password. Please try again.");
                }
            } catch (error) {
                console.error('Error resetting password:', error);
                showCustomAlert("An error occurred during the password reset process. Please try again.");
            }
        });

        // Initialize the flow by showing the first step when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            showStep('step-1');
        });
    </script>
</body>
</html>
