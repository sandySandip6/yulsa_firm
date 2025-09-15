<?php
// Gmail Email Service using PHPMailer
require_once 'frontend/header_footer/PHPMailer/src/Exception.php';
require_once 'frontend/header_footer/PHPMailer/src/PHPMailer.php';
require_once 'frontend/header_footer/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class GmailEmailService {
    private $config;
    private $mailer;
    
    public function __construct() {
        // Load Gmail configuration
        $this->config = include 'gmail-config.php';
        $this->mailer = new PHPMailer(true);
        $this->setupSMTP();
    }
    
    private function setupSMTP() {
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->config['smtp']['host'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->config['smtp']['username'];
            $this->mailer->Password = $this->config['smtp']['password'];
            $this->mailer->SMTPSecure = $this->config['smtp']['encryption'];
            $this->mailer->Port = $this->config['smtp']['port'];
            
            // Enable verbose debug output (remove in production)
            // $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
            
            // Set charset
            $this->mailer->CharSet = 'UTF-8';
            
            // Set sender
            $this->mailer->setFrom($this->config['smtp']['from_email'], $this->config['smtp']['from_name']);
            $this->mailer->addReplyTo($this->config['smtp']['from_email'], $this->config['smtp']['from_name']);
            
        } catch (Exception $e) {
            error_log("Gmail SMTP setup failed: " . $e->getMessage());
        }
    }
    
    public function sendAutoReply($to, $name, $services, $business_info) {
        try {
            // Clear previous recipients
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();
            
            // Add recipient
            $this->mailer->addAddress($to, $name);
            
            // Set email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "Thank you for your collaboration interest - Team Yulsa";
            $this->mailer->Body = $this->createEmailTemplate($name, $services, $business_info);
            $this->mailer->AltBody = $this->createTextEmail($name, $services, $business_info);
            
            // Send email
            $result = $this->mailer->send();
            
            if ($result) {
                error_log("Auto-reply email sent successfully to: " . $to);
                return true;
            } else {
                error_log("Failed to send auto-reply email to: " . $to);
                return false;
            }
            
        } catch (Exception $e) {
            error_log("Gmail email sending failed: " . $e->getMessage());
            return false;
        }
    }
    
    private function createEmailTemplate($name, $services, $business_info) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body { 
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                    line-height: 1.6; 
                    color: #333; 
                    margin: 0; 
                    padding: 0; 
                    background-color: #f4f4f4;
                }
                .email-container { 
                    max-width: 600px; 
                    margin: 20px auto; 
                    background-color: #ffffff;
                    border-radius: 10px;
                    overflow: hidden;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                .header { 
                    background: linear-gradient(135deg, #2c3e50, #34495e); 
                    color: white; 
                    padding: 30px 20px; 
                    text-align: center; 
                }
                .header h1 { 
                    margin: 0; 
                    font-size: 28px; 
                }
                .header .highlight { 
                    color: #e74c3c; 
                    font-weight: bold; 
                }
                .content { 
                    padding: 40px 30px; 
                    background-color: #ffffff; 
                }
                .footer { 
                    background-color: #34495e; 
                    color: white; 
                    padding: 20px; 
                    text-align: center; 
                    font-size: 12px; 
                }
                .services-list { 
                    background-color: #ecf0f1; 
                    padding: 20px; 
                    border-radius: 8px; 
                    margin: 20px 0; 
                    border-left: 4px solid #e74c3c;
                }
                .business-info { 
                    background-color: #e8f4f8; 
                    padding: 20px; 
                    border-radius: 8px; 
                    margin: 20px 0; 
                    border-left: 4px solid #3498db;
                }
                .cta-button {
                    display: inline-block;
                    background-color: #e74c3c;
                    color: white;
                    padding: 12px 30px;
                    text-decoration: none;
                    border-radius: 5px;
                    margin: 20px 0;
                }
                .signature {
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 2px solid #ecf0f1;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header'>
                    <h1>Team Yulsa<span class='highlight'>®</span></h1>
                    <p>Professional Accounting Services</p>
                </div>
                
                <div class='content'>
                    <h2>Dear " . htmlspecialchars($name) . ",</h2>
                    
                    <p>Thank you for your interest in collaborating with Team Yulsa! We have received your collaboration request and are excited about the potential partnership.</p>
                    
                    <div class='business-info'>
                        <strong>Your Business Information:</strong><br>
                        " . htmlspecialchars($business_info) . "
                    </div>
                    
                    <p><strong>Your Selected Services:</strong></p>
                    <div class='services-list'>
                        " . htmlspecialchars($services) . "
                    </div>
                    
                    <p>Our team will review your collaboration request and get back to you within 24-48 hours. We appreciate your patience as we carefully consider each partnership opportunity.</p>
                    
                    <p>In the meantime, feel free to explore our website to learn more about our comprehensive accounting services and how we can help your business grow.</p>
                    
                    <div class='signature'>
                        <p>Best regards,<br>
                        <strong>The Team Yulsa Partnership Team</strong><br>
                        <em>Professional Accounting Services</em></p>
                    </div>
                </div>
                
                <div class='footer'>
                    <p>© " . date('Y') . " Team Yulsa. All rights reserved.</p>
                    <p>This is an automated response. Please do not reply to this email.</p>
                    <p>For immediate assistance, contact us at info@teamyulsa.com</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    private function createTextEmail($name, $services, $business_info) {
        return "
Dear " . $name . ",

Thank you for your interest in collaborating with Team Yulsa! We have received your collaboration request and are excited about the potential partnership.

Your Business Information:
" . $business_info . "

Your Selected Services:
" . $services . "

Our team will review your collaboration request and get back to you within 24-48 hours. We appreciate your patience as we carefully consider each partnership opportunity.

In the meantime, feel free to explore our website to learn more about our comprehensive accounting services and how we can help your business grow.

Best regards,
The Team Yulsa Partnership Team
Professional Accounting Services

© " . date('Y') . " Team Yulsa. All rights reserved.
This is an automated response. Please do not reply to this email.
For immediate assistance, contact us at info@teamyulsa.com
        ";
    }
}
?>
