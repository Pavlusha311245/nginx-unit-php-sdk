# HasListeners

```php
trait HasListeners
{
    private array $_listeners = [];

    /**
     * Setup new listener
     *
     * @param Listener $listener
     * @return void
     */
    public function setListener(Listener $listener): void
    {
        $this->_listeners[$listener->getListener()] = $listener;
    }

    /**
     * Get listeners linked to object;
     *
     * @return mixed
     */
    public function getListeners(): array
    {
        return $this->_listeners;
    }

    /**
     * Check if listeners are empty or not
     *
     * @return bool
     */
    public function hasListeners(): bool
    {
        return !empty($this->_listeners);
    }
}
```
