let items = [
    { id: 1, name: 'Item 1' },
    { id: 2, name: 'Item 2' },
    { id: 3, name: 'Item 3' },
  ];
  
  export default function handler(req, res) {
    if (req.method === 'GET') {
      // Return all items
      res.status(200).json(items);
    } else if (req.method === 'POST') {
      // Create a new item
      const newItem = req.body;
      newItem.id = items.length + 1; // Generate an ID
      items.push(newItem);
      res.status(201).json(newItem);
    } else if (req.method === 'DELETE') {
      // Delete an item by ID
      const { id } = req.body;
      items = items.filter(item => item.id !== id);
      res.status(200).json({ message: `Item with ID ${id} deleted` });
    } else {
      res.status(405).json({ message: 'Method Not Allowed' });
    }
  }
  