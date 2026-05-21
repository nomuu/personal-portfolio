// server.js
const express = require("express");
const bodyParser = require("body-parser");
const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.json());

app.post("/webhook", (req, res) => {
  const query = req.body.queryResult.queryText.toLowerCase();

  let responseText = "Sorry, I don't understand that.";

  if (query.includes("xss")) {
    responseText = "XSS (Cross-Site Scripting) is a vulnerability where attackers inject malicious scripts into trusted websites.";
  } else if (query.includes("sql injection")) {
    responseText = "SQL Injection is an attack where malicious SQL code is inserted into a query to access or manipulate data.";
  } else if (query.includes("csrf")) {
    responseText = "CSRF (Cross-Site Request Forgery) tricks a user into performing actions without their consent on a trusted site.";
  } else if (query.includes("owasp top 10")) {
    responseText = "The OWASP Top 10 is a list of the most critical security risks for web apps, such as XSS, SQLi, and broken authentication.";
  }

  return res.json({
    fulfillmentText: responseText,
  });
});

app.listen(PORT, () => {
  console.log(`Webhook is running on port ${PORT}`);
});
