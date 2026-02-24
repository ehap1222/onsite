import { Link } from "react-router-dom";
import "./NavBar.css";

function NavBar() {
  return (
    <nav className="navbar navbar-expand-lg glass-navbar">
      <div className="container-fluid">
        <Link className="navbar-brand glass-brand" to="/">
          Ecommers-Project
        </Link>

        <button
          className="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="collapse navbar-collapse" id="navbarSupportedContent">
          <ul className="navbar-nav mx-auto mb-2 mb-lg-0">
            <li className="nav-item">
              <Link className="nav-link glass-link" to="/">Home</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link glass-link" to="/about">About</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link glass-link" to="/products">Products</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link glass-link" to="/contact">Contact</Link>
            </li>
          </ul>

          <form className="d-flex">
            <input
              className="form-control me-2 glass-input"
              type="search"
              placeholder="Search"
            />
            <button className="btn glass-btn" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </nav>
  );
}

export default NavBar;
