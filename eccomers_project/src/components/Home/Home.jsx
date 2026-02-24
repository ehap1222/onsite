import "./Home.css";

function Home() {
  return (
    <div className="home">
      {/* Hero Section */}
      <section className="hero">
        <div className="hero-content">
          <h1>Discover the Future of Shopping</h1>
          <p>
            Premium products. Seamless experience. Built for modern customers.
          </p>
          <button className="hero-btn">Shop Now</button>
        </div>
      </section>

      {/* Features Section */}
      <section className="features container">
        <div className="feature-card">
          <h3>Fast Delivery</h3>
          <p>Get your products delivered in record time.</p>
        </div>

        <div className="feature-card">
          <h3>Secure Payment</h3>
          <p>Your transactions are protected and encrypted.</p>
        </div>

        <div className="feature-card">
          <h3>Premium Quality</h3>
          <p>Only the best products from trusted brands.</p>
        </div>
      </section>
    </div>
  );
}

export default Home;
