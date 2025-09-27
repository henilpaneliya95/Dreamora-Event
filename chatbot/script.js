class ChatBot {
    constructor() {
        this.messageInput = document.getElementById('messageInput');
        this.chatMessages = document.getElementById('chatMessages');
        this.typingIndicator = document.getElementById('typingIndicator');
        this.sendButton = document.getElementById('sendButton');
        
        this.initializeEventListeners();
        this.responses = this.initializeResponses();
    }

    initializeEventListeners() {
        // Send message on Enter key
        this.messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        });

        // Send message on button click
        this.sendButton.addEventListener('click', () => {
            this.sendMessage();
        });
    }

    initializeResponses() {
        return {
            // Greetings
            'hello|hi|hey|good morning|good afternoon|good evening': [
                "Hello! 👋 Welcome to Dreamora Event! I'm excited to help you plan your perfect event. What type of celebration are you thinking about?",
                "Hi there! 🌟 Thanks for choosing Dreamora Event. We've been creating magical moments since September 22, 2025. How can I make your event dreams come true today?"
            ],

            // Services
            'services|what do you do|what services': [
                "🎉 At Dreamora Event, we specialize in:\n\n🎂 **Birthday Parties** - From intimate gatherings to grand celebrations\n💒 **Wedding Events** - Complete wedding planning and coordination\n🏢 **Official Programmes & Meetings** - Corporate events and business functions\n🎊 **Functions & Events** - All types of social gatherings\n🎪 **Festival Management** - Cultural and community festivals\n🎈 **Office Parties** - Team building and corporate celebrations\n\nWhich type of event interests you most?"
            ],

            // Birthday parties
            'birthday|birthday party|birthday celebration': [
                "🎂 **Birthday Party Planning by Dreamora Event!**\n\nWe create unforgettable birthday celebrations:\n\n✨ **Theme Decorations** - Any theme you can imagine\n🎈 **Balloon Arrangements** - Stunning balloon arches and displays\n🎵 **Entertainment** - DJs, performers, and activities\n🍰 **Catering Services** - Delicious cakes and party food\n📸 **Photography** - Capture every precious moment\n🎁 **Party Favors** - Special gifts for guests\n\nWhat's your budget range and how many guests are you expecting?"
            ],

            // Weddings
            'wedding|marriage|wedding event|wedding planning': [
                "💒 **Wedding Event Management by Dreamora Event!**\n\nYour dream wedding awaits:\n\n👰 **Complete Wedding Planning** - From engagement to reception\n💐 **Venue Decoration** - Stunning floral and lighting arrangements\n🎵 **Entertainment & Music** - Live bands, DJs, and traditional music\n📷 **Photography & Videography** - Professional wedding documentation\n🍽️ **Catering Services** - Multi-cuisine wedding feasts\n🚗 **Transportation** - Decorated cars and guest transport\n💍 **Coordination** - Timeline management and vendor coordination\n\nWhen is your special day? Let's start planning your perfect wedding!"
            ],

            // Official programmes
            'official|corporate|business|meeting|conference|official programme': [
                "🏢 **Official Programmes & Corporate Events by Dreamora Event!**\n\nProfessional event management:\n\n📊 **Corporate Meetings** - Board meetings and conferences\n🎯 **Product Launches** - Grand unveiling events\n🏆 **Award Ceremonies** - Recognition and appreciation events\n🤝 **Business Networking** - Professional networking events\n📺 **Press Conferences** - Media management and coordination\n📋 **Seminars & Workshops** - Educational and training events\n\nWhat type of official programme are you planning?"
            ],

            // Functions and events
            'function|event|celebration|party|gathering': [
                "🎊 **Functions & Events by Dreamora Event!**\n\nWe handle all types of celebrations:\n\n🎉 **Social Gatherings** - Family reunions and get-togethers\n🥳 **Anniversary Celebrations** - Milestone celebrations\n🎓 **Achievement Parties** - Graduation and success celebrations\n🎭 **Cultural Events** - Traditional and modern celebrations\n💫 **Special Occasions** - Any reason to celebrate!\n🎪 **Community Events** - Local festivals and gatherings\n\nTell me more about your event vision!"
            ],

            // Festivals
            'festival|festival management|cultural event': [
                "🎪 **Festival Management by Dreamora Event!**\n\nBringing communities together:\n\n🕯️ **Religious Festivals** - Traditional celebrations with respect\n🎨 **Cultural Festivals** - Art, music, and dance celebrations\n🎆 **Seasonal Festivals** - Holiday and seasonal events\n🏛️ **Community Festivals** - Local neighborhood celebrations\n🎭 **Arts Festivals** - Creative and artistic showcases\n🍽️ **Food Festivals** - Culinary celebrations\n\nWhich festival are you planning? We'll make it unforgettable!"
            ],

            // Office parties
            'office party|team building|corporate party|company party': [
                "🎈 **Office Party Planning by Dreamora Event!**\n\nBoost team morale with amazing parties:\n\n🎯 **Team Building Activities** - Fun and engaging team exercises\n🎉 **Holiday Parties** - Christmas, New Year, and seasonal celebrations\n🏆 **Achievement Celebrations** - Success and milestone parties\n🍕 **Casual Gatherings** - Informal team bonding events\n🎵 **Entertainment** - Games, music, and performances\n🍰 **Catering** - Office-friendly food and refreshments\n\nWhat's the occasion for your office party?"
            ],

            // Booking and website
            'book|booking|website|how to book|reservation': [
                "📅 **Easy Booking with Dreamora Event!**\n\nBook your event through our website:\n\n🌐 **Online Booking** - Visit our website for instant booking\n📞 **Direct Contact** - Call us for personalized consultation\n📝 **Event Details** - Share your requirements and preferences\n💰 **Transparent Pricing** - Clear quotes with no hidden costs\n⏰ **Quick Response** - We'll get back to you within 24 hours\n✅ **Confirmation** - Detailed event planning and timeline\n\nWould you like me to help you get started with your booking?"
            ],

            // Pricing
            'price|cost|budget|how much|pricing|rates': [
                "💰 **Transparent Pricing by Dreamora Event!**\n\nOur pricing depends on:\n\n👥 **Guest Count** - Number of attendees\n⏰ **Event Duration** - Length of celebration\n🎯 **Services Required** - Decoration, catering, entertainment\n📍 **Venue Requirements** - Location and setup needs\n🎨 **Customization Level** - Special themes and personalization\n\n**Starting Packages:**\n🎂 Birthday Parties: ₹15,000 onwards\n💒 Weddings: ₹1,00,000 onwards\n🏢 Corporate Events: ₹25,000 onwards\n🎉 Other Functions: ₹10,000 onwards\n\nShare your requirements for a detailed quote!"
            ],

            // Contact information
            'contact|phone|address|location|how to reach': [
                "📞 **Contact Dreamora Event!**\n\n🏢 **Company:** Dreamora Event\n📅 **Established:** September 22, 2025\n🌟 **Specialization:** Complete Event Management\n\n📱 **Get in Touch:**\n📞 Phone: Available on our website\n📧 Email: Contact through our booking portal\n🌐 Website: Visit for instant booking\n📍 Location: Service across multiple locations\n\n⏰ **Business Hours:** 9 AM - 8 PM (7 days a week)\n🚀 **Quick Response:** 24-hour response guarantee\n\nReady to start planning your perfect event?"
            ],

            // Company information
            'about|company|dreamora|who are you|tell me about': [
                "🌟 **About Dreamora Event**\n\n✨ **Vision:** Creating magical moments and unforgettable experiences\n📅 **Founded:** September 22, 2025 (We're brand new and excited!)\n🎯 **Mission:** Making every celebration perfect and stress-free\n\n🏆 **Why Choose Us:**\n✅ Fresh perspective with innovative ideas\n✅ Professional team with creative vision\n✅ Complete end-to-end event management\n✅ Transparent pricing and honest service\n✅ Customer satisfaction guarantee\n✅ Latest trends and modern techniques\n\nWe're passionate about making your events extraordinary!"
            ],

            // Thank you
            'thank you|thanks|appreciate': [
                "🙏 You're most welcome! It's our pleasure to help you plan amazing events.\n\n✨ At Dreamora Event, your satisfaction is our priority. We're here whenever you need us!\n\n💫 Ready to turn your event dreams into reality? Let's start planning something magical together!"
            ],

            // Login and Registration
            'login|log in|sign in|signin': [
                "🔐 **Login Process at Dreamora Event!**\n\n⚠️ **Important:** You need to register first before you can login!\n\n📝 **Steps to Get Started:**\n1️⃣ **Register First** - Create your account on our website\n2️⃣ **Verify Email** - Check your email for verification link\n3️⃣ **Complete Profile** - Add your event preferences\n4️⃣ **Login** - Use your credentials to access your account\n\n🌐 **New User?** Please register first on our website\n🔑 **Existing User?** Login with your registered email and password\n\nWould you like me to guide you through the registration process?"
            ],

            'register|registration|sign up|signup|create account|new account': [
                "📝 **Registration at Dreamora Event!**\n\n✨ **Easy Registration Process:**\n\n🌐 **Step 1:** Visit our website\n📧 **Step 2:** Enter your email address\n🔒 **Step 3:** Create a secure password\n📱 **Step 4:** Add your phone number\n👤 **Step 5:** Complete your profile details\n📧 **Step 6:** Verify your email address\n\n🎉 **After Registration You Can:**\n✅ Login to your account\n✅ Book events online\n✅ Track your event status\n✅ Access exclusive offers\n✅ Save your preferences\n\n⏰ **Registration takes just 2 minutes!**\nReady to create your account?"
            ],

            'account|profile|user account|my account': [
                "👤 **Account Management at Dreamora Event!**\n\n🔐 **Account Features:**\n\n📝 **Registration Required First!**\n• Create account → Then login\n• Email verification needed\n• Complete profile setup\n\n💼 **Account Benefits:**\n✅ **Event Booking** - Quick online booking\n✅ **Order History** - Track all your events\n✅ **Saved Preferences** - Your favorite themes and services\n✅ **Exclusive Offers** - Member-only discounts\n✅ **Priority Support** - Faster customer service\n✅ **Event Reminders** - Never miss important dates\n\n🆕 **New to Dreamora?** Register first, then login!\n🔑 **Already have account?** Login to access all features!"
            ],

            'password|forgot password|reset password': [
                "🔑 **Password Help at Dreamora Event!**\n\n🔒 **Password Requirements:**\n• Minimum 8 characters\n• Include letters and numbers\n• Add special characters for security\n\n❓ **Forgot Password?**\n1️⃣ Go to login page\n2️⃣ Click 'Forgot Password'\n3️⃣ Enter your registered email\n4️⃣ Check email for reset link\n5️⃣ Create new password\n\n⚠️ **No Account Yet?** You must register first!\n\n🔐 **Security Tips:**\n• Don't share your password\n• Use unique password for your account\n• Update password regularly\n\nNeed help with registration or login?"
            ],

            // Developer information
            'developer|developers|who made|who created|who developed|who built|development team|team|creator': [
                "👨‍💻 **Meet the Dreamora Event Development Team!**\n\n🌟 **Our Talented Developers:**\n\n👤 **Henil Paneliya**\n💻 Frontend & Backend Developer\n🚀 Full-stack development expertise\n\n👤 **Prachi Panchal**\n💻 Frontend & Backend Developer\n🎨 UI/UX and server-side development\n\n👤 **Pranali Kunth**\n🎯 Frontend Developer & Code Tester\n✅ Quality assurance and testing\n\n👤 **Krisha Devani**\n🔍 Code Tester\n🛡️ Software testing and quality control\n\n🎉 **This amazing team worked together to create the Dreamora Event platform!**\n\n💪 **Team Expertise:**\n✅ Full-stack web development\n✅ User interface design\n✅ Quality testing and assurance\n✅ Event management solutions\n\nThanks for asking about our awesome team! 🙌"
            ],

            // Payment and billing process
            'payment|bill|pay|billing|advance|installment|payment process': [
                "💳 **Payment Process at Dreamora Event!**\n\n💰 **Easy Payment Structure:**\n\n🔒 **Booking Confirmation:**\n⚠️ **40% Advance Payment** - Compulsory at booking time\n✅ This secures your event date and starts planning\n📅 Required to confirm your reservation\n\n💸 **Remaining Payment:**\n🕐 **60% Balance** - Pay later as per schedule\n📋 **Flexible Options:**\n• 30 days before event (30%)\n• 7 days before event (30%)\n• OR pay full 60% anytime before event\n\n📊 **Payment Methods:**\n💳 Credit/Debit Cards\n🏦 Bank Transfer\n📱 UPI/Digital Wallets\n💵 Cash (for advance only)\n\n🧾 **What's Included:**\n✅ Detailed invoice and receipt\n✅ Payment schedule reminder\n✅ Secure transaction guarantee\n✅ Refund policy protection\n\n📞 **Need payment assistance? Contact our billing team!**"
            ],

            'advance|advance payment|booking amount|40%|forty percent': [
                "💰 **Advance Payment Details - Dreamora Event**\n\n🔒 **40% Advance Payment Policy:**\n\n⚠️ **Compulsory Requirement:**\n• 40% of total event cost\n• Must be paid at booking time\n• Non-negotiable for date confirmation\n• Secures your event slot\n\n💡 **Why 40% Advance?**\n✅ Confirms your serious commitment\n✅ Allows us to block your date\n✅ Enables immediate planning start\n✅ Covers initial planning costs\n✅ Protects against cancellations\n\n🎯 **Example Calculation:**\n• Total Event Cost: ₹1,00,000\n• Advance Payment: ₹40,000 (40%)\n• Remaining Balance: ₹60,000\n\n📅 **Balance Payment Options:**\n• Pay anytime before event\n• Installments available\n• Final payment 7 days before event\n\n🔐 **Secure & Transparent Process!**"
            ],

            'remaining payment|balance|60%|final payment|due amount': [
                "💸 **Remaining Payment Information - Dreamora Event**\n\n📊 **60% Balance Payment:**\n\n⏰ **Flexible Payment Schedule:**\n\n🗓️ **Option 1: Split Payments**\n• 30% - 30 days before event\n• 30% - 7 days before event\n\n🗓️ **Option 2: Single Payment**\n• Full 60% - Anytime before event\n• Minimum 7 days before event date\n\n📅 **Payment Reminders:**\n✅ Email notifications sent\n✅ SMS reminders for due dates\n✅ Personal call from our team\n✅ Easy online payment portal\n\n💳 **Payment Methods:**\n🏦 Bank transfer (preferred)\n💳 Online card payment\n📱 UPI/Digital wallets\n\n⚠️ **Important Notes:**\n• Final payment mandatory before event\n• Late payment may affect services\n• Receipt provided for all payments\n\n🎉 **Pay conveniently and enjoy your event!**"
            ],

            // Default response for unmatched queries
            'default': [
                "🤔 I'd love to help you with that! Let me connect you with the right information about Dreamora Event.\n\n🎉 **Quick Questions:**\n• What type of event are you planning?\n• Do you need information about our services?\n• Would you like to know about pricing?\n• Are you ready to book an event?\n\n💬 Feel free to ask about birthdays, weddings, corporate events, festivals, or any celebration!"
            ]
        };
    }

    sendMessage() {
        const message = this.messageInput.value.trim();
        if (!message) return;

        // Display user message
        this.displayMessage(message, 'user');
        
        // Clear input
        this.messageInput.value = '';
        
        // Show typing indicator
        this.showTypingIndicator();
        
        // Generate and display bot response
        setTimeout(() => {
            this.hideTypingIndicator();
            const response = this.generateResponse(message);
            this.displayMessage(response, 'bot');
        }, 1000 + Math.random() * 1000); // Random delay for natural feel
    }

    sendQuickReply(type) {
        const quickReplies = {
            'services': 'What services do you offer?',
            'booking': 'How can I book an event?',
            'pricing': 'What are your pricing details?',
            'contact': 'How can I contact you?'
        };

        const message = quickReplies[type];
        this.messageInput.value = message;
        this.sendMessage();

        // Add visual feedback
        event.target.classList.add('clicked');
        setTimeout(() => {
            event.target.classList.remove('clicked');
        }, 200);
    }

    // Function to detect thank you messages
    detectThankYou(message) {
        const thankYouPatterns = [
            'thank you', 'thanks', 'thankyou', 'ty', 'thx', 'thank u',
            'धन्यवाद', 'शुक्रिया', 'thnx', 'thank', 'appreciated'
        ];
        
        const lowerMessage = message.toLowerCase().trim();
        return thankYouPatterns.some(pattern => lowerMessage.includes(pattern));
    }

    // Function to generate welcome responses
    getWelcomeResponse() {
        const welcomeMessages = [
            "You're most welcome! 😊 We're always here to help make your events memorable. Is there anything else I can assist you with?",
            "You're very welcome! 🌟 It's our pleasure to help you create amazing events. Feel free to ask if you need anything more!",
            "My pleasure! 🎉 We love helping our customers plan perfect events. Don't hesitate to reach out anytime!",
            "You're welcome! 💫 At Dreamora Event, customer satisfaction is our priority. How else can I help you today?",
            "Happy to help! 🎊 We're always excited to be part of your special moments. Let me know if you need more assistance!"
        ];
        
        return welcomeMessages[Math.floor(Math.random() * welcomeMessages.length)];
    }

    generateResponse(userMessage) {
        const message = userMessage.toLowerCase();
        
        // Check for thank you message first
        if (this.detectThankYou(userMessage)) {
            return this.getWelcomeResponse();
        }

        // Check each response pattern
        for (const [pattern, responses] of Object.entries(this.responses)) {
            if (pattern !== 'default') {
                const keywords = pattern.split('|');
                if (keywords.some(keyword => message.includes(keyword))) {
                    return this.getRandomResponse(responses);
                }
            }
        }
        
        // Return default response if no match found
        return this.getRandomResponse(this.responses.default);
    }

    getRandomResponse(responses) {
        return responses[Math.floor(Math.random() * responses.length)];
    }

    displayMessage(message, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        
        // Format message with basic markdown-like formatting
        const formattedMessage = this.formatMessage(message);
        messageContent.innerHTML = formattedMessage;
        
        const messageTime = document.createElement('div');
        messageTime.className = 'message-time';
        messageTime.textContent = this.getCurrentTime();
        
        messageDiv.appendChild(messageContent);
        messageDiv.appendChild(messageTime);
        
        this.chatMessages.appendChild(messageDiv);
        this.scrollToBottom();
    }

    formatMessage(message) {
        return message
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') // Bold text
            .replace(/\n/g, '<br>') // Line breaks
            .replace(/^• /gm, '<br>• ') // Bullet points
            .replace(/^✅ /gm, '<br>✅ ') // Checkmarks
            .replace(/^🎂 |^💒 |^🏢 |^🎊 |^🎪 |^🎈 /gm, '<br>$&'); // Event icons
    }

    getCurrentTime() {
        const now = new Date();
        return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    showTypingIndicator() {
        this.typingIndicator.style.display = 'flex';
        this.scrollToBottom();
    }

    hideTypingIndicator() {
        this.typingIndicator.style.display = 'none';
    }

    scrollToBottom() {
        setTimeout(() => {
            this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
        }, 100);
    }
}

// Quick reply function (global scope for onclick handlers)
function sendQuickReply(type) {
    if (window.chatBot) {
        window.chatBot.sendQuickReply(type);
    }
}

// Send message function (global scope for onclick handlers)
function sendMessage() {
    if (window.chatBot) {
        window.chatBot.sendMessage();
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.chatBot = new ChatBot();
    console.log('Dreamora Event Chat Bot initialized successfully! 🎉');
});