import express from 'express';
import cors from 'cors';
import { securityHeaders } from './middleware/headers.mjs';

const app = express();

// Enable CORS
app.use(cors());

// Apply security headers
app.use(securityHeaders);

// Parse JSON bodies
app.use(express.json());

// Parse URL-encoded bodies
app.use(express.urlencoded({ extended: true }));

// Serve static files from the browser directory
app.use(express.static('browser'));

export default app; 