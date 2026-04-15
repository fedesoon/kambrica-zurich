export default function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).send('Method Not Allowed');
  }
  const clave = req.body?.clave || '';
  if (clave.length > 4) {
    res.status(200).send('OK');
  } else {
    res.status(200).send('La clave debe tener al menos 8 caracteres.');
  }
}
