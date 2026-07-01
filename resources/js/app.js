import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Start Alpine after DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
});

// Handle dark mode persistence via localStorage
// This runs before Alpine to prevent FOUC (flash of unstyled content)
(function() {
    const darkMode = localStorage.getItem('dark_mode');
    if (darkMode === 'true') {
        document.documentElement.classList.add('dark');
    } else if (darkMode === 'false') {
        document.documentElement.classList.remove('dark');
    }
})();

// Robust Clipboard Copy Fallback (works in non-HTTPS/local dev environments)
window.copyToClipboard = function(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text)
            .then(() => {
                alert('Tautan berhasil disalin!');
            })
            .catch(() => {
                fallbackCopyToClipboard(text);
            });
    } else {
        fallbackCopyToClipboard(text);
    }
};

function fallbackCopyToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            alert('Tautan berhasil disalin!');
        } else {
            console.error('Fallback: Copy command was unsuccessful');
        }
    } catch (err) {
        console.error('Fallback: Unable to copy', err);
    }
    document.body.removeChild(textArea);
}

// Global Share Handler
window.sharePost = function(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).catch(err => {
            console.log('Share cancelled or failed', err);
        });
    } else {
        window.copyToClipboard(url);
    }
};

