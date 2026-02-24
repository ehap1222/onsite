// Products.jsx
import "./Products.css";
import axios from "axios";
import { useEffect, useState } from "react";
import Swal from "sweetalert2";
import { useNavigate, useParams } from "react-router-dom";

// ---------------------------
// ProductCard Component
// ---------------------------
function ProductCard({ product, onAddToCart }) {
  const navigate = useNavigate();

  const goToDetails = () => navigate(`/products/${product.id}`);

  return (
    <div className="product-card">
      <img src={product.image} alt={product.title} />
      <h3>{product.title}</h3>
      <p className="price">${product.price}</p>
      <div style={{ display: "flex", justifyContent: "space-between" }}>
        <button onClick={() => onAddToCart(product)} className="buy-btn">Add to Cart</button>
        <button onClick={goToDetails} className="buy-btn">View Details</button>
      </div>
    </div>
  );
}

// ---------------------------
// ProductsDetails Component
// ---------------------------
export function ProductsDetails() {
  const { id } = useParams();
  const [product, setProduct] = useState(null);

  useEffect(() => {
    axios
      .get(`https://fakestoreapi.com/products/${id}`)
      .then((res) => setProduct(res.data))
      .catch((err) => console.log(err));
  }, [id]);

  const addToCart = () => {
    Swal.fire({
      icon: "success",
      title: "Added to Cart!",
      text: `${product.title} has been added.`,
    });
  };

  if (!product) return <p>Loading...</p>;

  return (
    <div className="product-details">
      <img src={product.image} alt={product.title} />
      <h2>{product.title}</h2>
      <p>{product.description}</p>
      <h4>${product.price}</h4>
      <button onClick={addToCart} className="buy-btn">Add to Cart</button>
    </div>
  );
}

// ---------------------------
// ProductsList Component
// ---------------------------
export default function ProductsList() {
  const [products, setProducts] = useState([]);
  const [activeCategory, setActiveCategory] = useState("electronics");
  const categories = ["electronics", "jewelery", "men's clothing", "women's clothing"];

  const getProductsByCategory = async (category) => {
    const res = await axios.get(`https://fakestoreapi.com/products/category/${category}`);
    setProducts(res.data);
  };

  useEffect(() => {
    getProductsByCategory(activeCategory);
  }, [activeCategory]);

  const addToCart = (product) => {
    Swal.fire({
      icon: "success",
      title: "Added to Cart!",
      text: `${product.title} has been added.`,
      confirmButtonColor: "#0d6efd",
    });
  };

  return (
    <div className="products-page">
      <div className="products-hero">
        <div>
          <h1>Our Products</h1>
          <p>Explore our categories and find your favorite items!</p>
        </div>
      </div>

      <div className="categories">
        {categories.map((cat) => (
          <button
            key={cat}
            className={`category-btn ${activeCategory === cat ? "active" : ""}`}
            onClick={() => setActiveCategory(cat)}
          >
            {cat}
          </button>
        ))}
      </div>

      <div className="products-grid">
        {products.map((p) => (
          <ProductCard key={p.id} product={p} onAddToCart={addToCart} />
        ))}
      </div>
    </div>
  );
}
