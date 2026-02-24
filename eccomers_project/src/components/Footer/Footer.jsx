import "./Footer.css";
import { Link } from "react-router-dom";

function Footer() {
  return (
    <footer className="footer">
      <div className="footer-container">
        <div className="footer-brand">
          <h2>Ecommers-Project</h2>
          <p>Premium shopping experience for modern customers.</p>
        </div>

        <div className="footer-links">
          <div className="link-group">
            <h4>Company</h4>
            <Link to="/">Home</Link>
            <Link to="/about">About</Link>
            <Link to="/contact">Contact</Link>
          </div>

          <div className="link-group">
            <h4>Products</h4>
            <Link to="/products">All Products</Link>
            <Link to="/products">Categories</Link>
          </div>
        </div>
      </div>
      <div className="footer-bottom">
        <p>
          © {new Date().getFullYear()} Ecommers-Project. All rights reserved.
        </p>
      </div>
    </footer>
  );
}

export default Footer;
