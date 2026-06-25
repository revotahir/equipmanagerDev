const jwt = require("jsonwebtoken");
const config = require("./config");

/**
 * Socket.io authentication middleware
 * SuperAdmin (role='superadmin' or user_type=1) may join ANY dispute chat.
 */
async function authenticateSocket(socket, next) {
try {
const token = socket.handshake.auth.token;
if (!token) {
console.error("Authentication error: No token provided");
return next(new Error("Authentication token required"));
}

let decoded;
try {
decoded = jwt.verify(token, config.JWT_SECRET);
} catch (err) {
console.error("[Auth] JWT verification failed:", err.message);
return next(new Error("Invalid or expired token"));
}

if (!decoded.user_id || !decoded.chat_id || !decoded.role) {
console.error("[Auth] Invalid token payload - missing required fields");
return next(new Error("Invalid token payload"));
}

socket.userId       = decoded.user_id;
socket.chatId       = decoded.chat_id;
socket.userRole     = decoded.role;
socket.userType     = decoded.user_type ?? null;
socket.isSuperAdmin = (decoded.role === 'superadmin' || decoded.user_type === 1);
socket.chatStatus   = "open";

// SuperAdmin bypass — can join any dispute chat
if (socket.isSuperAdmin) {
console.log("[Auth] SuperAdmin " + socket.userId + " authenticated for dispute chat " + socket.chatId);
return next();
}

console.log("[Auth] User " + socket.userId + " authenticated for chat " + socket.chatId + " as " + socket.userRole);
next();
} catch (error) {
console.error("[Auth] Authentication middleware error:", error.message);
next(new Error("Authentication failed"));
}
}

module.exports = authenticateSocket;
