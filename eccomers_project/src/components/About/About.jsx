import "./About.css";

function About() {
  return (
    <div className="about">
    
      <section className="about-hero">
        <div className="about-hero-content">
          <h1>About Ecommers-Project</h1>
          <p>
            We are dedicated to providing the best online shopping experience 
            with premium products, fast delivery, and secure payments.
          </p>
        </div>
      </section>

      <section className="about-mission container">
        <h2>Our Mission</h2>
        <p>
          Our mission is to simplify online shopping by offering a seamless 
          and enjoyable experience for all our customers. We aim to deliver 
          quality products, fast service, and complete trust.
        </p>

        <div className="team-cards">
          <div className="team-card">
            <h3>Jane Doe</h3>
            <p>CEO git remote remove origin
& Founder</p>
          </div>
          <div className="team-card">
            <h3>John Smith</h3>
            <p>Head of Operations</p>
          </div>
          <div className="team-card">
            <h3>Emma Lee</h3>
            <p>Lead Designer</p>
          </div>
        </div>
      </section>
    </div>
  );
}

export default About;
