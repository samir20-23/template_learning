// pages/product/[id].js
import { useRouter } from 'next/router';

export default function ProductPage() {
  const router = useRouter();
  const { id } = router.query;

  const productData = {
    1: { name: 'Product 1', description: 'Description for Product 1' },
    2: { name: 'Product 2', description: 'Description for Product 2' },
    3: { name: 'Product 3', description: 'Description for Product 3' },
  };

  const product = productData[id];

  if (!product) {
    return <div>Product not found</div>;
  }

  return (
    <div>
      <h1>{product.name}</h1>
      <p>{product.description}</p>
    </div>
  );
}
