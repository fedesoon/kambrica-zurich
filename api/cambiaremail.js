export default function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).send('Method Not Allowed');
  }
  const email = req.body?.email || '';
  if (email.length > 4) {
    res.status(200).send('OK');
  } else {
    res.status(200).send('La dirección ingresada no es válida.');
  }
}
