// src/components/SongList.tsx
import React, { useEffect, useState } from 'react';
import { 
    Container, 
    Typography, 
    List, 
    ListItem, 
    ListItemText,
    Button,
    Dialog,
    DialogTitle,
    DialogContent,
    TextField,
    DialogActions,
    Pagination
} from '@mui/material';
import axios from 'axios';

interface Song {
    id: number;
    title: string;
    youtube_link: string;
    plays: number;
}

export const SongList: React.FC = () => {
    const [songs, setSongs] = useState<Song[]>([]);
    const [page, setPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const [openDialog, setOpenDialog] = useState(false);
    const [newSong, setNewSong] = useState({ title: '', youtube_link: '' });

    useEffect(() => {
        fetchSongs();
    }, [page]);

    const fetchSongs = async () => {
        try {
            const response = await axios.get(`/api/songs?page=${page}`);
            setSongs(response.data.data);
            setTotalPages(Math.ceil(response.data.total / response.data.per_page));
        } catch (error) {
            console.error('Error fetching songs:', error);
        }
    };

    const handleSubmit = async () => {
        try {
            await axios.post('/api/suggestions', newSong);
            setOpenDialog(false);
            setNewSong({ title: '', youtube_link: '' });
            alert('Sugestão enviada com sucesso!');
        } catch (error) {
            console.error('Error submitting suggestion:', error);
            alert('Erro ao enviar sugestão. Tente novamente.');
        }
    };

    return (
        <Container maxWidth="md">
            <Typography variant="h4" component="h1" gutterBottom>
                Top 5 - Tião Carreiro e Pardinho
            </Typography>

            <List>
                {songs.map((song, index) => (
                    <ListItem key={song.id}>
                        <ListItemText
                            primary={`${index + 1}. ${song.title}`}
                            secondary={`Reproduções: ${song.plays}`}
                        />
                        <Button 
                            variant="outlined" 
                            href={song.youtube_link} 
                            target="_blank"
                        >
                            Ouvir no YouTube
                        </Button>
                    </ListItem>
                ))}
            </List>

            <Pagination
                count={totalPages}
                page={page}
                onChange={(_, value) => setPage(value)}
            />

            <Button
                variant="contained"
                color="primary"
                onClick={() => setOpenDialog(true)}
                style={{ marginTop: 20 }}
            >
                Sugerir Música
            </Button>

            <Dialog open={openDialog} onClose={() => setOpenDialog(false)}>
                <DialogTitle>Sugerir Nova Música</DialogTitle>
                <DialogContent>
                    <TextField
                        autoFocus
                        margin="dense"
                        label="Título da Música"
                        fullWidth
                        value={newSong.title}
                        onChange={(e) => setNewSong({ ...newSong, title: e.target.value })}
                    />
                    <TextField
                        margin="dense"
                        label="Link do YouTube"
                        fullWidth
                        value={newSong.youtube_link}
                        onChange={(e) => setNewSong({ ...newSong, youtube_link: e.target.value })}
                    />
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => setOpenDialog(false)}>Cancelar</Button>
                    <Button onClick={handleSubmit} color="primary">
                        Enviar
                    </Button>
                </DialogActions>
            </Dialog>
        </Container>
    );
};